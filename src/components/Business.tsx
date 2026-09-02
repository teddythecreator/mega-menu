import { CHANNELS, NAME_IDEAS, PENDING, TIERS } from "../lib/data";
import { IconArrow, IconStar, Reveal, SectionHead } from "../lib/Shared";
import { CheckItem, usePersistentSet } from "./Roadmap";

export default function Business() {
  const names = usePersistentSet("tbmx-names-v1");
  const pending = usePersistentSet("tbmx-pending-v1");
  const done = PENDING.filter((_, i) => pending.set.has(`p${i}`)).length;

  return (
    <section className="scroll-mt-28 border-t border-[var(--border)] bg-[var(--bg2)]/60">
      <div className="mx-auto max-w-[1240px] px-4 py-20 sm:px-6 md:py-28">
        {/* ── §12 Distribución ── */}
        <div id="licencia">
          <SectionHead
            num="12"
            kicker="Distribución / venta / licencia"
            title="GPL se vende con servicio"
            lead="La licencia GPL es obligatoria por derivar de WordPress. El negocio no está en candar el código: está en el acceso, las actualizaciones y el soporte — el modelo estándar del ecosistema."
          />

          <div className="grid gap-6 lg:grid-cols-12">
            <Reveal className="lg:col-span-5">
              <div className="card relative h-full overflow-hidden p-7">
                <span className="pointer-events-none absolute -right-4 -top-7 select-none font-display text-[8.5rem] leading-none text-[var(--accent)] opacity-[0.08]">GPL</span>
                <p className="font-mono text-[11px] uppercase tracking-[0.22em] text-[var(--accent)]">Licencia</p>
                <p className="mt-3 font-display text-2xl uppercase leading-tight">Código abierto, servicio cerrado</p>
                <ul className="mt-5 space-y-3 text-[14px] leading-relaxed text-[var(--muted)]">
                  <li className="flex gap-3"><span aria-hidden="true" className="mt-[7px] h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--accent)]" />Licencia anual por sitio o paquete agencia; updates + soporte incluidos.</li>
                  <li className="flex gap-3"><span aria-hidden="true" className="mt-[7px] h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--accent)]" />Venta propia con Freemius o EDD para licencias y actualizaciones.</li>
                  <li className="flex gap-3"><span aria-hidden="true" className="mt-[7px] h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--accent)]" />Requisitos legales: política de reembolso, términos de licencia y changelog público.</li>
                </ul>
              </div>
            </Reveal>

            <div className="lg:col-span-7">
              <Reveal delay={110}>
                <div className="card overflow-hidden">
                  <div className="border-b border-[var(--border2)] bg-[var(--panel2)] px-5 py-3 font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--muted)]">
                    Tiers de licencia anual
                  </div>
                  <ul className="divide-y divide-[var(--border)]">
                    {TIERS.map((t) => (
                      <li key={t.name} className={`row-flash flex flex-wrap items-center gap-x-6 gap-y-1 px-5 py-4 hover:bg-[var(--panel2)] ${t.recommended ? "border-l-4 border-l-[var(--accent)] bg-[var(--panel2)]" : ""}`}>
                        <span className="w-24 font-display text-lg uppercase">{t.name}</span>
                        <span className="flex-1 text-[13px] text-[var(--muted)]">{t.ideal}</span>
                        <span className="font-mono text-[11px] uppercase tracking-wider text-[var(--faint)]">{t.note}</span>
                        {t.recommended && (
                          <span className="bg-[var(--accent)] px-2 py-0.5 font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-white" style={{ borderRadius: "var(--radius)" }}>
                            recomendado
                          </span>
                        )}
                      </li>
                    ))}
                  </ul>
                </div>
              </Reveal>
              <div className="mt-6 space-y-3">
                {CHANNELS.map((c, i) => (
                  <Reveal key={c.t} delay={i * 90} className="group flex items-start gap-4">
                    <span className="mt-1 flex h-7 w-7 shrink-0 items-center justify-center border border-[var(--border2)] font-mono text-[11px] text-[var(--accent)] transition-colors duration-200 group-hover:border-[var(--accent)] group-hover:bg-[var(--accent)] group-hover:text-white" style={{ borderRadius: "var(--radius)" }}>
                      {String.fromCharCode(65 + i)}
                    </span>
                    <span>
                      <span className="block text-sm font-semibold">{c.t}</span>
                      <span className="block text-[13px] text-[var(--muted)]">{c.d}</span>
                    </span>
                  </Reveal>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* ── §13 Nombre ── */}
        <div id="nombre" className="mt-24 scroll-mt-28">
          <Reveal className="mb-10">
            <p className="font-mono text-[11px] uppercase tracking-[0.22em] text-[var(--muted)]">
              <span className="font-semibold text-[var(--accent)]">§13</span>
              <span className="mx-3 text-[var(--faint)]">/</span>Nombre — sugerencias
            </p>
            <div className="mt-3 flex flex-wrap items-center gap-5">
              <h2 className="font-display text-[clamp(1.9rem,4.6vw,3.4rem)] uppercase leading-[1.02] tracking-tight">
                Bautiza el plugin
              </h2>
              <span className="rotate-[-4deg] border-2 border-dashed border-[var(--accent2)] px-3 py-1.5 font-display text-sm uppercase tracking-[0.16em] text-[var(--accent2)]">
                pendiente
              </span>
            </div>
            <p className="mt-3 max-w-2xl text-[15px] leading-relaxed text-[var(--muted)]">
              Marca tu shortlist con la estrella — queda guardada en tu navegador. Antes de decidir,
              comprueba la disponibilidad de <b className="text-[var(--fg)]">dominio</b> y de{" "}
              <b className="text-[var(--fg)]">slug en el repositorio de WordPress</b>.
            </p>
          </Reveal>
          <div className="flex flex-wrap gap-3">
            {NAME_IDEAS.map((n, i) => {
              const on = names.set.has(`n${i}`);
              return (
                <Reveal key={n.name} delay={i * 60}>
                  <button
                    onClick={() => names.toggle(`n${i}`)}
                    aria-pressed={on}
                    className={`group flex items-center gap-3 border px-4 py-3 transition-all duration-200 ${
                      on
                        ? "border-[var(--accent)] bg-[var(--accent)] text-white"
                        : "border-[var(--border2)] bg-[var(--panel)] text-[var(--fg)] hover:-translate-y-0.5 hover:border-[var(--accent)]"
                    }`}
                    style={{ borderRadius: "var(--radius)" }}
                  >
                    <IconStar className={`h-4 w-4 transition-transform duration-200 group-hover:scale-110 ${on ? "text-white" : "text-[var(--accent2)]"}`} filled={on} />
                    <span className="text-left">
                      <span className="block font-display text-sm uppercase tracking-wide">{n.name}</span>
                      <span className={`block font-mono text-[9px] uppercase tracking-[0.18em] ${on ? "text-white/70" : "text-[var(--faint)]"}`}>{n.kind}</span>
                    </span>
                  </button>
                </Reveal>
              );
            })}
          </div>
        </div>

        {/* ── Decisiones pendientes ── */}
        <div className="mt-24">
          <Reveal>
            <div className="card border-l-4 border-l-[var(--accent2)] p-6 sm:p-8">
              <div className="flex flex-wrap items-center justify-between gap-3">
                <p className="font-display text-xl uppercase tracking-tight">
                  Notas / decisiones pendientes <span className="font-mono text-sm text-[var(--muted)] normal-case tracking-normal">— {done}/{PENDING.length} resueltas</span>
                </p>
                <a href="#top" className="group inline-flex items-center gap-2 font-mono text-[11px] uppercase tracking-widest text-[var(--muted)] hover:text-[var(--fg)]">
                  volver al inicio <IconArrow className="h-3.5 w-3.5 -rotate-90 text-[var(--accent)] transition-transform group-hover:-translate-y-0.5" />
                </a>
              </div>
              <ul className="mt-4 grid gap-x-10 sm:grid-cols-2">
                {PENDING.map((p, i) => (
                  <CheckItem key={p} checked={pending.set.has(`p${i}`)} onToggle={() => pending.toggle(`p${i}`)}>
                    {p}
                  </CheckItem>
                ))}
              </ul>
            </div>
          </Reveal>
        </div>
      </div>
    </section>
  );
}
