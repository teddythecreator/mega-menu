import { A11Y_POINTS, KEYBOARD, PERF_POINTS, SECURITY_POINTS } from "../lib/data";
import { IconBolt, IconKey, IconShield, Reveal, SectionHead } from "../lib/Shared";

const ARIA_SNIPPET = `<li data-tbmx="mega">
  <button aria-haspopup="true"
          aria-expanded="false"
          aria-controls="panel-7">
    Servicios
  </button>

  <div id="panel-7"
       role="region"
       aria-label="Panel Servicios"
       hidden>
    <!-- layout de la Biblioteca Divi -->
  </div>
</li>`;

export default function Quality() {
  return (
    <section id="calidad" className="mx-auto max-w-[1240px] scroll-mt-28 px-4 py-20 sm:px-6 md:py-28">
      <SectionHead
        num="6–8"
        kicker="Accesibilidad · Rendimiento · Seguridad"
        title="Requisitos, no opcionales"
        lead="El patrón disclosure de WAI-ARIA no es un añadido: es el contrato del plugin. Lo mismo con el presupuesto de bytes y el saneamiento de cada entrada."
      />

      <div className="grid gap-6 lg:grid-cols-12">
        {/* A11y */}
        <Reveal className="lg:col-span-5">
          <div className="card h-full border-t-2 border-t-[var(--accent)] p-6 sm:p-7">
            <p className="flex items-center gap-2.5 font-display text-lg uppercase">
              <IconKey className="h-5 w-5 text-[var(--accent)]" /> Accesibilidad
            </p>
            <div className="code-slab mt-5 overflow-x-auto p-4 text-[11.5px] leading-relaxed">
              <pre>{ARIA_SNIPPET}</pre>
            </div>
            <ul className="mt-5 divide-y divide-[var(--border)]">
              {KEYBOARD.map((k) => (
                <li key={k.k} className="row-flash flex items-center justify-between gap-4 py-3 hover:bg-[var(--panel2)]">
                  <kbd className="shrink-0 border border-[var(--border2)] bg-[var(--panel2)] px-2.5 py-1 font-mono text-[11px] font-semibold text-[var(--accent)]" style={{ borderRadius: "calc(var(--radius) - 4px)" }}>
                    {k.k}
                  </kbd>
                  <span className="text-right text-[13px] text-[var(--muted)]">{k.d}</span>
                </li>
              ))}
            </ul>
            <ul className="mt-4 space-y-2.5">
              {A11Y_POINTS.map((p) => (
                <li key={p} className="flex gap-3 text-[13px] leading-relaxed text-[var(--muted)]">
                  <span aria-hidden="true" className="mt-[7px] h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--accent)]" />
                  {p}
                </li>
              ))}
            </ul>
          </div>
        </Reveal>

        {/* Rendimiento */}
        <Reveal delay={120} className="lg:col-span-4">
          <div className="card h-full border-t-2 border-t-[var(--accent2)] p-6 sm:p-7">
            <p className="flex items-center gap-2.5 font-display text-lg uppercase">
              <IconBolt className="h-5 w-5 text-[var(--accent2)]" /> Rendimiento
            </p>
            <div className="mt-5 border border-[var(--border)] bg-[var(--panel2)] p-4 text-center" style={{ borderRadius: "var(--radius)" }}>
              <p className="font-display text-4xl text-[var(--accent2)]">&lt; 5 KB</p>
              <p className="mt-1 font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--muted)]">presupuesto JS del MVP</p>
            </div>
            <ul className="mt-5 space-y-3">
              {PERF_POINTS.map((p) => (
                <li key={p} className="flex gap-3 text-[13px] leading-relaxed text-[var(--muted)]">
                  <span aria-hidden="true" className="mt-[7px] h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--accent2)]" />
                  {p}
                </li>
              ))}
            </ul>
          </div>
        </Reveal>

        {/* Seguridad */}
        <Reveal delay={220} className="lg:col-span-3">
          <div className="card h-full border-t-2 border-t-[var(--ok)] p-6 sm:p-7">
            <p className="flex items-center gap-2.5 font-display text-lg uppercase">
              <IconShield className="h-5 w-5 text-[var(--ok)]" /> Seguridad
            </p>
            <ul className="mt-5 space-y-3">
              {SECURITY_POINTS.map((p) => (
                <li key={p} className="flex gap-3 text-[13px] leading-relaxed text-[var(--muted)]">
                  <span aria-hidden="true" className="mt-[7px] h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--ok)]" />
                  {p}
                </li>
              ))}
            </ul>
            <p className="mt-5 border-t border-[var(--border)] pt-4 font-mono text-[10px] uppercase tracking-[0.18em] text-[var(--faint)]">
              probar con Divi activo, Divi Builder en otros temas y sin Divi
            </p>
          </div>
        </Reveal>
      </div>
    </section>
  );
}
