import { useState } from "react";
import { FILE_TREE, INTEGRATION, META_KEYS, PIPELINE, STACK } from "../lib/data";
import { IconBolt, IconChevron, IconLayers, IconShield, IconWp, Reveal } from "../lib/Shared";

const KIND_STYLE: Record<string, string> = {
  dir: "text-[var(--accent2)] border-[var(--accent2)]",
  php: "text-[var(--accent)] border-[var(--accent)]",
  css: "text-[var(--ok)] border-[var(--ok)]",
  js: "text-[var(--fg)] border-[var(--border2)]",
  txt: "text-[var(--muted)] border-[var(--border2)]",
};

export default function Tech() {
  return (
    <section id="arquitectura" className="scroll-mt-28 border-t border-[var(--border)] bg-[var(--bg2)]/60">
      <div className="mx-auto max-w-[1240px] px-4 py-20 sm:px-6 md:py-28">
        <div className="grid gap-14 lg:grid-cols-12">
          {/* ── Columna fija ── */}
          <div className="lg:col-span-4">
            <div className="lg:sticky lg:top-28">
              <SectionHeadCompact num="4" kicker="Arquitectura técnica" title={["Stack nativo,", "cero fricción"]} />
              <Reveal delay={120}>
                <p className="text-[15px] leading-relaxed text-[var(--muted)]">
                  PHP 8 con APIs nativas de WordPress y JS vanilla empaquetado simple. Nada de
                  frameworks: el MVP cabe en archivos planos y el build llega solo si el proyecto crece.
                </p>
              </Reveal>

              <div id="stack" className="mt-8 scroll-mt-32 space-y-3">
                {STACK.map((s, i) => (
                  <Reveal key={s.t} delay={i * 80} className="card card-hover flex items-center gap-4 p-4">
                    <span className="font-display text-lg text-[var(--accent)]">{String(i + 1).padStart(2, "0")}</span>
                    <span>
                      <span className="block font-mono text-sm font-semibold tracking-wide">{s.t}</span>
                      <span className="mt-0.5 block text-[13px] text-[var(--muted)]">{s.d}</span>
                    </span>
                  </Reveal>
                ))}
              </div>

              <Reveal delay={200} className="card mt-6 border-l-2 border-l-[var(--accent2)] bg-[var(--panel2)] p-5">
                <p className="flex items-center gap-2 font-mono text-[11px] uppercase tracking-[0.2em] text-[var(--accent2)]">
                  <IconShield className="h-3.5 w-3.5" /> Reglas de la casa
                </p>
                <ul className="mt-3 space-y-2 text-[13px] leading-relaxed text-[var(--muted)]">
                  <li>· Enqueue condicional: 0 KB donde no hay megamenú.</li>
                  <li>· Sin jQuery. JS al final o con <code className="font-mono text-[var(--fg)]">defer</code>.</li>
                  <li>· Nonces + <code className="font-mono text-[var(--fg)]">edit_theme_options</code> siempre.</li>
                  <li>· Prefijo <code className="font-mono text-[var(--fg)]">tbmx_</code> / <code className="font-mono text-[var(--fg)]">_tbmx_</code> en todo.</li>
                </ul>
              </Reveal>
            </div>
          </div>

          {/* ── Contenido técnico ── */}
          <div className="space-y-16 lg:col-span-8">
            <FileTreeBlock />
            <DataModelBlock />
            <IntegrationBlock />
            <PipelineBlock />
          </div>
        </div>
      </div>
    </section>
  );
}

/* Encabezado compacto para la columna sticky */
function SectionHeadCompact({ num, kicker, title }: { num: string; kicker: string; title: string[] }) {
  return (
    <Reveal>
      <p className="font-mono text-[11px] uppercase tracking-[0.22em] text-[var(--muted)]">
        <span className="font-semibold text-[var(--accent)]">§{num}</span>
        <span className="mx-3 text-[var(--faint)]">/</span>
        {kicker}
      </p>
      <h2 className="mt-3 font-display text-[clamp(1.7rem,3.4vw,2.6rem)] uppercase leading-[1.02] tracking-tight">
        {title.map((l, i) => (
          <span key={i} className="block">{l}</span>
        ))}
      </h2>
    </Reveal>
  );
}

/* ── Estructura de archivos interactiva ── */
function FileTreeBlock() {
  const [open, setOpen] = useState<number | null>(1);
  return (
    <Reveal>
      <div id="archivos" className="scroll-mt-32">
        <div className="mb-5 flex flex-wrap items-baseline justify-between gap-2">
          <h3 className="flex items-center gap-3 font-display text-xl uppercase tracking-tight sm:text-2xl">
            <IconLayers className="h-5 w-5 text-[var(--accent)]" /> Estructura de archivos
          </h3>
          <p className="font-mono text-[11px] uppercase tracking-widest text-[var(--faint)]">
            {FILE_TREE.length} nodos · clic para inspeccionar
          </p>
        </div>
        <div className="card overflow-hidden">
          <div className="flex items-center gap-1.5 border-b border-[var(--border)] bg-[var(--panel2)] px-4 py-2.5">
            <span className="h-2.5 w-2.5 rounded-full bg-[var(--accent)]" />
            <span className="h-2.5 w-2.5 rounded-full bg-[var(--accent2)]" />
            <span className="h-2.5 w-2.5 rounded-full bg-[var(--ok)]" />
            <span className="ml-3 font-mono text-[11px] text-[var(--muted)]">tbmx-megamenu — árbol del plugin</span>
          </div>
          <ul className="divide-y divide-[var(--border)] font-mono text-[13px]">
            {FILE_TREE.map((f, i) => {
              const isDir = f.kind === "dir";
              const isOpen = open === i;
              return (
                <li key={f.name + i}>
                  <button
                    onClick={() => setOpen(isOpen ? null : i)}
                    aria-expanded={isOpen}
                    className={`row-flash flex w-full items-center gap-3 px-4 py-2.5 text-left hover:bg-[var(--panel2)] ${isOpen ? "bg-[var(--panel2)]" : ""}`}
                    style={{ paddingLeft: `${16 + f.depth * 22}px` }}
                  >
                    <IconChevron className={`h-3 w-3 shrink-0 text-[var(--faint)] transition-transform duration-200 ${isOpen ? "rotate-0" : "-rotate-90"} ${isDir ? "text-[var(--accent2)]" : ""}`} />
                    <span className={`truncate ${isDir ? "font-semibold text-[var(--accent2)]" : "text-[var(--fg)]"}`}>{f.name}</span>
                    <span className={`ml-auto shrink-0 border px-1.5 py-0.5 text-[9px] uppercase tracking-[0.14em] ${KIND_STYLE[f.kind]}`} style={{ borderRadius: "calc(var(--radius) - 5px)" }}>
                      {f.kind}
                    </span>
                  </button>
                  <div hidden={!isOpen} className="drawer-in border-l-2 border-[var(--accent)] bg-[var(--panel2)]/60 px-4 py-3 font-sans text-[13px] leading-relaxed text-[var(--muted)]" style={{ marginLeft: `${16 + f.depth * 22}px` }}>
                    {f.desc}
                  </div>
                </li>
              );
            })}
          </ul>
        </div>
      </div>
    </Reveal>
  );
}

/* ── Modelo de datos ── */
function DataModelBlock() {
  return (
    <Reveal>
      <div id="datos" className="scroll-mt-32">
        <h3 className="mb-5 font-display text-xl uppercase tracking-tight sm:text-2xl">
          Modelo de datos <span className="text-[var(--accent)]">— meta, no tablas</span>
        </h3>
        <div className="card overflow-hidden">
          <div className="grid grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)_minmax(0,1.4fr)] border-b border-[var(--border2)] bg-[var(--panel2)] font-mono text-[10px] uppercase tracking-[0.18em] text-[var(--muted)] max-sm:hidden">
            <span className="px-5 py-3">Clave</span>
            <span className="px-5 py-3">Tipo</span>
            <span className="px-5 py-3">Propósito</span>
          </div>
          <ul className="divide-y divide-[var(--border)]">
            {META_KEYS.map((m) => (
              <li key={m.key} className="row-flash grid grid-cols-1 gap-1 px-5 py-4 hover:bg-[var(--panel2)] sm:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)_minmax(0,1.4fr)] sm:items-baseline sm:gap-4 sm:py-3.5">
                <code className="font-mono text-[13px] font-semibold text-[var(--accent)]">{m.key}</code>
                <code className="font-mono text-[11px] text-[var(--accent2)]">{m.type}</code>
                <span className="text-[13px] text-[var(--muted)]">{m.desc}</span>
              </li>
            ))}
          </ul>
        </div>
        <div className="mt-4 grid gap-4 sm:grid-cols-2">
          <div className="card card-hover border-l-2 border-l-[var(--ok)] p-5">
            <p className="font-mono text-[11px] uppercase tracking-[0.2em] text-[var(--ok)]">Por ítem</p>
            <p className="mt-2 text-[13px] leading-relaxed text-[var(--muted)]">
              Todo vive en <code className="font-mono text-[var(--fg)]">get_post_meta</code> sobre el{" "}
              <code className="font-mono text-[var(--fg)]">nav_menu_item</code>. Sin tablas propias en el MVP.
            </p>
          </div>
          <div className="card card-hover border-l-2 border-l-[var(--accent)] p-5">
            <p className="font-mono text-[11px] uppercase tracking-[0.2em] text-[var(--accent)]">Global</p>
            <p className="mt-2 text-[13px] leading-relaxed text-[var(--muted)]">
              Una sola opción <code className="font-mono text-[var(--fg)]">tbmx_megamenu_settings</code> (array) vía Settings API.
            </p>
          </div>
        </div>
      </div>
    </Reveal>
  );
}

/* ── Integración WP + Divi ── */
function IntegrationBlock() {
  const icons = [IconWp, IconLayers, IconBolt];
  return (
    <Reveal>
      <div>
        <h3 className="mb-5 font-display text-xl uppercase tracking-tight sm:text-2xl">Integración WP × Divi</h3>
        <div className="grid gap-4 md:grid-cols-3">
          {INTEGRATION.map((it, i) => {
            const Ic = icons[i];
            return (
              <Reveal key={it.t} delay={i * 100} className="card card-hover group p-5">
                <Ic className="h-5 w-5 text-[var(--accent)] transition-transform duration-300 group-hover:-translate-y-1" />
                <p className="mt-3 font-mono text-sm font-semibold tracking-wide">{it.t}</p>
                <p className="mt-2 text-[13px] leading-relaxed text-[var(--muted)]">{it.d}</p>
              </Reveal>
            );
          })}
        </div>
      </div>
    </Reveal>
  );
}

/* ── Pipeline de render ── */
function PipelineBlock() {
  return (
    <Reveal>
      <div id="pipeline" className="scroll-mt-32">
        <h3 className="mb-6 font-display text-xl uppercase tracking-tight sm:text-2xl">Pipeline de render <span className="text-[var(--accent)]">front</span></h3>
        <ol className="relative space-y-0 border-l-2 border-[var(--border2)] pl-0">
          {PIPELINE.map((s, i) => (
            <Reveal as="li" key={s.t} delay={i * 110} className="group relative pb-8 pl-8 last:pb-0">
              <span className="absolute -left-[13px] top-0 flex h-6 w-6 items-center justify-center border-2 border-[var(--accent)] bg-[var(--bg2)] font-mono text-[11px] font-semibold text-[var(--accent)] transition-transform duration-300 group-hover:scale-110" style={{ borderRadius: "var(--radius)" }}>
                {i + 1}
              </span>
              <p className="font-mono text-sm font-semibold tracking-wide transition-colors group-hover:text-[var(--accent)]">{s.t}</p>
              <p className="mt-1.5 max-w-xl text-[13px] leading-relaxed text-[var(--muted)]">{s.d}</p>
            </Reveal>
          ))}
        </ol>
      </div>
    </Reveal>
  );
}


