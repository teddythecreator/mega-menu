import { DECISION_ROWS, REASONS } from "../lib/data";
import { IconArrow, IconCheck, MaskTitle, Reveal } from "../lib/Shared";

export default function Cover() {
  return (
    <>
      {/* ═══ Portada de especificación ═══ */}
      <section id="top" className="relative mx-auto max-w-[1240px] px-4 pb-16 pt-12 sm:px-6 md:pt-20">
        <div className="grid gap-12 lg:grid-cols-12">
          <div className="lg:col-span-7">
            <Reveal>
              <p className="caret font-mono text-[11px] uppercase tracking-[0.26em] text-[var(--muted)] sm:text-xs">
                TBMX/DOC-01 · REV v0.1 — borrador vivo
              </p>
            </Reveal>
            <MaskTitle
              className="mt-6 font-display uppercase leading-[0.95] tracking-tight text-[clamp(2.6rem,8.5vw,6.2rem)]"
              lines={[
                <>Mega menú</>,
                <>
                  para <span className="text-[var(--accent)]">Divi</span>
                  <span className="ml-3 inline-block align-super font-mono text-[clamp(0.7rem,1.6vw,1rem)] font-medium tracking-[0.2em] text-[var(--muted)]">
                    [plugin WP]
                  </span>
                </>,
              ]}
              step={140}
            />
            <Reveal delay={220}>
              <p className="mt-7 max-w-xl text-[15px] leading-relaxed text-[var(--muted)] sm:text-base">
                Fuente única de verdad para diseñar y construir el plugin con{" "}
                <b className="text-[var(--fg)]">Claude Code</b> en otra máquina: guía de decisiones,
                especificación técnica, roadmap y prompts. Cada panel del menú es un{" "}
                <b className="text-[var(--fg)]">layout de la Biblioteca de Divi</b>.
              </p>
              <div className="mt-8 flex flex-wrap items-center gap-6">
                <a href="#roadmap" className="group inline-flex items-center gap-3 border border-[var(--fg)] bg-[var(--fg)] px-5 py-3 font-mono text-xs font-semibold uppercase tracking-[0.18em] text-[var(--bg)] transition-colors duration-200 hover:border-[var(--accent)] hover:bg-[var(--accent)] hover:text-white" style={{ borderRadius: "var(--radius)" }}>
                  Ir al roadmap
                  <IconArrow className="h-3.5 w-3.5 rotate-90 transition-transform duration-200 group-hover:translate-y-0.5" />
                </a>
                <a href="#prompts" className="link-underline font-mono text-xs uppercase tracking-[0.18em] text-[var(--muted)] hover:text-[var(--fg)]">
                  Ver los prompts →
                </a>
              </div>
            </Reveal>
          </div>

          {/* Ficha técnica */}
          <div className="lg:col-span-5">
            <Reveal delay={160}>
              <div className="card relative overflow-hidden p-6 sm:p-7">
                <div className="pointer-events-none absolute -right-3 top-4 rotate-[8deg] border-2 border-[var(--accent)] px-3 py-1.5 font-display text-[11px] uppercase tracking-[0.14em] text-[var(--accent)] opacity-90">
                  usar Divi como panel
                </div>
                <p className="font-mono text-[10px] uppercase tracking-[0.26em] text-[var(--faint)]">Ficha del documento</p>
                <dl className="mt-5 divide-y divide-[var(--border)]">
                  {[
                    ["Documento", "DOC-01 · fuente única de verdad"],
                    ["Versión", "v0.1 — borrador vivo"],
                    ["Objetivo", "Plugin WP reutilizable y vendible"],
                    ["Dependencias JS", "0 (vanilla)"],
                    ["Presupuesto JS", "< 5 KB en el MVP"],
                    ["Compatibilidad", "Divi + menús nativos de WP"],
                  ].map(([k, v]) => (
                    <div key={k} className="flex items-baseline justify-between gap-4 py-3">
                      <dt className="font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">{k}</dt>
                      <dd className="text-right text-sm font-medium">{v}</dd>
                    </div>
                  ))}
                  <div className="flex items-center justify-between gap-4 py-3">
                    <dt className="font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">Estado</dt>
                    <dd className="flex items-center gap-2 text-sm font-medium">
                      <span className="pulse-dot h-2 w-2 rounded-full bg-[var(--ok)]" />
                      en curso — actualizar al avanzar
                    </dd>
                  </div>
                </dl>
                <div className="mt-5 grid grid-cols-3 gap-2 text-center">
                  {[
                    ["§13", "nombre pendiente"],
                    ["4", "fases + QA"],
                    ["8", "prompts listos"],
                  ].map(([n, l]) => (
                    <div key={l} className="border border-[var(--border)] bg-[var(--panel2)] px-2 py-3" style={{ borderRadius: "var(--radius)" }}>
                      <p className="font-display text-xl text-[var(--accent)]">{n}</p>
                      <p className="mt-1 font-mono text-[9px] uppercase tracking-[0.14em] text-[var(--muted)]">{l}</p>
                    </div>
                  ))}
                </div>
              </div>
            </Reveal>
          </div>
        </div>
      </section>

      {/* ═══ §0 Resumen ejecutivo ═══ */}
      <section id="resumen" className="mx-auto max-w-[1240px] scroll-mt-28 px-4 pb-20 sm:px-6">
        <Reveal>
          <div className="card relative overflow-hidden bg-[var(--panel)] p-7 sm:p-10">
            <div className="pointer-events-none absolute inset-y-0 left-0 w-1 bg-[var(--accent)]" />
            <div className="grid gap-10 lg:grid-cols-12">
              <div className="lg:col-span-7">
                <p className="font-mono text-[11px] uppercase tracking-[0.24em] text-[var(--accent)]">§0 · Resumen ejecutivo</p>
                <h2 className="mt-4 font-display text-[clamp(1.4rem,3vw,2.2rem)] uppercase leading-[1.08]">
                  Construir un <span className="text-[var(--accent)]">plugin de WordPress</span> que
                  convierte los menús nativos en mega menús con estética Divi.
                </h2>
                <p className="mt-5 max-w-xl text-[15px] leading-relaxed text-[var(--muted)]">
                  El contenido de cada panel es un layout de la Biblioteca de Divi. El plugin no
                  programa un editor: resuelve lo difícil — <b className="text-[var(--fg)]">disparador, panel, estilo,
                  accesibilidad y responsive</b> — y deja el diseño donde ya sabemos hacerlo.
                </p>
              </div>
              <div className="lg:col-span-5">
                <ol className="space-y-4">
                  {REASONS.map((r, i) => (
                    <Reveal as="li" key={r.t} delay={i * 90} className="group flex gap-4">
                      <span className="mt-0.5 font-display text-sm text-[var(--accent)]">{String(i + 1).padStart(2, "0")}</span>
                      <span>
                        <span className="block text-sm font-semibold transition-colors group-hover:text-[var(--accent)]">{r.t}</span>
                        <span className="mt-0.5 block text-[13px] leading-relaxed text-[var(--muted)]">{r.d}</span>
                      </span>
                    </Reveal>
                  ))}
                </ol>
              </div>
            </div>
            <span className="stamp-in pointer-events-none absolute right-6 top-6 hidden rotate-[-8deg] border-[3px] border-[var(--accent)] px-4 py-2 font-display text-lg uppercase tracking-[0.18em] text-[var(--accent)] sm:block" style={{ borderRadius: "var(--radius)" }}>
              Elegido ✓
            </span>
          </div>
        </Reveal>
      </section>

      {/* ═══ §1 Decisión de arquitectura ═══ */}
      <section id="decision" className="mx-auto max-w-[1240px] scroll-mt-28 px-4 pb-20 sm:px-6">
        <Reveal className="mb-10">
          <p className="font-mono text-[11px] uppercase tracking-[0.22em] text-[var(--muted)]">
            <span className="font-semibold text-[var(--accent)]">§1</span>
            <span className="mx-3 text-[var(--faint)]">/</span>Decisión de arquitectura
          </p>
          <MaskTitle
            className="mt-3 font-display uppercase leading-[1.02] tracking-tight text-[clamp(1.9rem,4.6vw,3.4rem)]"
            lines={["Tres vías, un veredicto"]}
          />
        </Reveal>

        <Reveal delay={120}>
          <div className="card overflow-x-auto">
            <table className="w-full min-w-[760px] border-collapse text-left">
              <thead>
                <tr className="border-b border-[var(--border2)] font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--muted)]">
                  <th className="px-5 py-4 font-medium">Opción</th>
                  <th className="px-5 py-4 font-medium">Reutilizable</th>
                  <th className="px-5 py-4 font-medium">Vendible</th>
                  <th className="px-5 py-4 font-medium">Esfuerzo</th>
                  <th className="px-5 py-4 font-medium">Veredicto</th>
                </tr>
              </thead>
              <tbody>
                {DECISION_ROWS.map((r) => (
                  <tr
                    key={r.option}
                    className={`row-flash border-b border-[var(--border)] last:border-0 ${
                      r.chosen
                        ? "border-l-4 border-l-[var(--accent)] bg-[var(--panel2)]"
                        : "hover:bg-[var(--panel2)]"
                    }`}
                  >
                    <td className="px-5 py-5">
                      <span className={`text-sm font-semibold ${r.chosen ? "text-[var(--fg)]" : "text-[var(--muted)]"}`}>{r.option}</span>
                    </td>
                    <td className="px-5 py-5">
                      <VerdictCell ok={r.re === "Sí"} label={r.re} />
                    </td>
                    <td className="px-5 py-5">
                      <VerdictCell ok={r.ve.startsWith("Sí")} label={r.ve} />
                    </td>
                    <td className="px-5 py-5">
                      <span className={`font-mono text-xs uppercase tracking-wider ${r.ef === "Medio" ? "text-[var(--accent2)]" : "text-[var(--muted)]"}`}>{r.ef}</span>
                    </td>
                    <td className="px-5 py-5">
                      {r.chosen ? (
                        <span className="inline-flex items-center gap-1.5 bg-[var(--accent)] px-2.5 py-1 font-mono text-[10px] font-semibold uppercase tracking-[0.16em] text-white" style={{ borderRadius: "var(--radius)" }}>
                          <IconCheck className="h-3 w-3" /> Recomendado
                        </span>
                      ) : (
                        <span className="text-[13px] text-[var(--muted)]">{r.verdict}</span>
                      )}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </Reveal>
        <Reveal delay={200}>
          <p className="mt-5 max-w-3xl text-sm leading-relaxed text-[var(--muted)]">
            <span className="font-mono text-[var(--accent)]">↳</span> Plugin WP independiente integrado con el sistema de
            menús, usando Divi solo para el contenido del panel: <b className="text-[var(--fg)]">desacoplado de su API interna</b>,
            menos frágil ante updates de Divi.
          </p>
        </Reveal>
      </section>

      {/* ═══ §2 Definición de producto ═══ */}
      <section id="producto" className="mx-auto max-w-[1240px] scroll-mt-28 px-4 pb-24 sm:px-6">
        <div className="grid gap-10 lg:grid-cols-12">
          <Reveal className="lg:col-span-7">
            <p className="font-mono text-[11px] uppercase tracking-[0.22em] text-[var(--muted)]">
              <span className="font-semibold text-[var(--accent)]">§2</span>
              <span className="mx-3 text-[var(--faint)]">/</span>Definición de producto
            </p>
            <blockquote className="relative mt-6 border-l-2 border-[var(--accent)] pl-6">
              <span aria-hidden="true" className="pointer-events-none absolute -left-2 -top-8 font-display text-[7rem] leading-none text-[var(--accent)] opacity-15">“</span>
              <p className="font-display text-[clamp(1.3rem,2.8vw,2rem)] uppercase leading-[1.15]">
                Mega menús profesionales en Divi, en minutos, diseñados con el propio Divi — accesibles y rápidos.
              </p>
            </blockquote>
            <p className="mt-6 max-w-xl text-[15px] leading-relaxed text-[var(--muted)]">
              La promesa sostiene dos productos en uno: la <b className="text-[var(--fg)]">plantilla estándar de cabeceras</b> de la
              agencia y un <b className="text-[var(--fg)]">add-on con licencia</b> para el ecosistema Divi.
            </p>
          </Reveal>
          <div className="lg:col-span-5">
            <Reveal delay={140}>
              <dl className="card divide-y divide-[var(--border)] p-2">
                <div className="flex items-center justify-between gap-4 px-4 py-4">
                  <dt className="font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">Nombre</dt>
                  <dd>
                    <a href="#nombre" className="link-underline inline-block border border-dashed border-[var(--accent2)] px-2.5 py-1 font-mono text-xs uppercase tracking-widest text-[var(--accent2)]" style={{ borderRadius: "var(--radius)" }}>
                      [pendiente] → §13
                    </a>
                  </dd>
                </div>
                <div className="flex items-center justify-between gap-4 px-4 py-4">
                  <dt className="font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">Uso interno</dt>
                  <dd className="text-right text-sm">Plantilla de cabeceras de la agencia</dd>
                </div>
                <div className="flex items-center justify-between gap-4 px-4 py-4">
                  <dt className="font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">Producto</dt>
                  <dd className="text-right text-sm">Licencia anual por sitio / paquete agencia</dd>
                </div>
                <div className="flex items-center justify-between gap-4 px-4 py-4">
                  <dt className="font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">Público</dt>
                  <dd className="text-right text-sm">Estudios y freelancers que usan Divi, sin tocar código</dd>
                </div>
              </dl>
            </Reveal>
          </div>
        </div>
      </section>
    </>
  );
}

function VerdictCell({ ok, label }: { ok: boolean; label: string }) {
  return (
    <span className="flex items-center gap-2">
      <span
        className={`flex h-5 w-5 items-center justify-center border ${
          ok ? "border-[var(--ok)] text-[var(--ok)]" : "border-[var(--border2)] text-[var(--faint)]"
        }`}
        style={{ borderRadius: "calc(var(--radius) - 4px)" }}
      >
        {ok ? <IconCheck className="h-3 w-3" /> : <span className="text-[10px]">—</span>}
      </span>
      <span className={`text-[13px] ${ok ? "text-[var(--fg)]" : "text-[var(--muted)]"}`}>{label}</span>
    </span>
  );
}
