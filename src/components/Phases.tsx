import { PHASES } from "../lib/data";
import { Reveal, SectionHead } from "../lib/Shared";

export default function Phases() {
  return (
    <section id="fases" className="mx-auto max-w-[1240px] scroll-mt-28 px-4 py-20 sm:px-6 md:py-28">
      <SectionHead
        num="3"
        kicker="Alcance por fases"
        title="MVP primero, producto después"
        lead="Cada fase es vendible por sí misma. La v0.1 ya aporta valor real en cualquier proyecto Divi de la agencia; la v1.0 convierte el plugin en producto; la v2.0 abre el foso competitivo."
      />

      <div className="relative">
        {/* riel */}
        <span aria-hidden="true" className="absolute bottom-6 left-[13px] top-2 w-px bg-[var(--border2)] md:left-1/2 md:-translate-x-1/2" />
        <div className="space-y-10">
          {PHASES.map((p, i) => {
            const left = i % 2 === 0;
            return (
              <Reveal key={p.tag} className={`relative md:w-[calc(50%-2.6rem)] ${left ? "md:mr-auto" : "md:ml-auto"}`}>
                {/* nodo del riel */}
                <span
                  aria-hidden="true"
                  className={`absolute top-7 h-4 w-4 rotate-45 border-2 border-[var(--accent)] left-[6px] ${
                    i === 0 ? "bg-[var(--accent)]" : "bg-[var(--bg)]"
                  } ${left ? "md:left-[calc(100%+2.1rem)]" : "md:-left-[3.1rem]"}`}
                />
                <div className={`card card-hover ml-10 p-6 sm:p-7 md:ml-0 ${i === 0 ? "border-[var(--accent)]/60" : ""}`}>
                  <div className="flex flex-wrap items-baseline gap-x-4 gap-y-2">
                    <span className={`font-display text-[clamp(1.6rem,3vw,2.4rem)] uppercase leading-none ${i === 0 ? "text-[var(--accent)]" : ""}`}>
                      {p.tag}
                    </span>
                    {p.badge && (
                      <span className="inline-flex items-center gap-1.5 bg-[var(--accent)] px-2.5 py-1 font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-white" style={{ borderRadius: "var(--radius)" }}>
                        <span className="h-1.5 w-1.5 rounded-full bg-white pulse-dot" /> {p.badge}
                      </span>
                    )}
                  </div>
                  <p className="mt-1.5 font-mono text-[11px] uppercase tracking-[0.2em] text-[var(--muted)]">{p.name}</p>
                  <ul className="mt-5 space-y-3">
                    {p.items.map((it) => (
                      <li key={it} className="group flex gap-3 text-[14px] leading-relaxed text-[var(--muted)]">
                        <span aria-hidden="true" className="mt-[7px] h-2 w-2 shrink-0 rotate-45 border border-[var(--accent)] transition-colors duration-200 group-hover:bg-[var(--accent)]" />
                        <span className="transition-colors duration-200 group-hover:text-[var(--fg)]">{it}</span>
                      </li>
                    ))}
                  </ul>
                  <p className="mt-5 border-t border-[var(--border)] pt-4 font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--faint)]">
                    {p.items.length} entregables · checklist en §10
                  </p>
                </div>
              </Reveal>
            );
          })}
        </div>
      </div>
    </section>
  );
}
