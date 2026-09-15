import { INTERACTION, PRESET_META, TOKENS_COLOR, TOKENS_MISC, type PresetId } from "../lib/data";
import { Reveal, SectionHead } from "../lib/Shared";

export default function Design({ preset, onPreset }: { preset: PresetId; onPreset: (p: PresetId) => void }) {
  const meta = PRESET_META[preset];
  return (
    <section id="diseno" className="scroll-mt-28 border-t border-[var(--border)] bg-[var(--bg2)]/60">
      <div className="mx-auto max-w-[1240px] px-4 py-20 sm:px-6 md:py-28">
        <SectionHead
          num="5"
          kicker="Diseño / UX"
          title="Tokens que pintan el sitio entero"
          lead="El theming del plugin vive en custom properties. Pruébalo: estos tres presets son las mismas --tbmx-* que consumirá megamenu.css — y cambian esta página en vivo, sin recompilar nada."
        />

        {/* ── Selector de presets ── */}
        <div className="grid gap-10 lg:grid-cols-12">
          <Reveal className="lg:col-span-5">
            <p className="font-mono text-[11px] uppercase tracking-[0.22em] text-[var(--muted)]">Presets de estilo · v1.0</p>
            <div className="mt-4 inline-flex border border-[var(--border2)] p-1" style={{ borderRadius: "var(--radius)" }} role="tablist" aria-label="Preset de estilo">
              {(Object.keys(PRESET_META) as PresetId[]).map((p) => (
                <button
                  key={p}
                  role="tab"
                  aria-selected={preset === p}
                  onClick={() => onPreset(p)}
                  className={`flex items-center gap-2 px-4 py-2.5 font-mono text-xs uppercase tracking-widest transition-all duration-200 ${
                    preset === p ? "bg-[var(--fg)] font-semibold text-[var(--bg)]" : "text-[var(--muted)] hover:text-[var(--fg)]"
                  }`}
                  style={{ borderRadius: "calc(var(--radius) - 3px)" }}
                >
                  <span className="flex -space-x-1">
                    {PRESET_META[p].swatches.slice(0, 3).map((s, i) => (
                      <span key={i} className="h-2.5 w-2.5 rounded-full border border-[var(--border2)]" style={{ background: s }} />
                    ))}
                  </span>
                  {PRESET_META[p].label}
                </button>
              ))}
            </div>
            <p className="mt-4 max-w-md text-sm leading-relaxed text-[var(--muted)]">
              <b className="text-[var(--fg)]">{meta.label}</b> — {meta.desc}
            </p>

            {/* Mini-panel simulado: se repinta solo */}
            <div className="card mt-7 overflow-hidden">
              <div className="flex items-center gap-2 border-b border-[var(--border)] bg-[var(--panel2)] px-4 py-2.5">
                <span className="h-2 w-2 rounded-full bg-[var(--accent)]" />
                <span className="font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">vista previa · tbmx-panel</span>
                <span className="ml-auto font-mono text-[10px] text-[var(--faint)]">role="region"</span>
              </div>
              <div className="grid grid-cols-3 gap-3 p-5">
                {["Servicios", "Soluciones", "Recursos"].map((c) => (
                  <div key={c}>
                    <p className="font-mono text-[10px] uppercase tracking-[0.18em] text-[var(--accent)]">{c}</p>
                    <div className="mt-3 space-y-2">
                      <span className="block h-1.5 w-full bg-[var(--border2)]" style={{ borderRadius: "var(--radius)" }} />
                      <span className="block h-1.5 w-4/5 bg-[var(--border)]" style={{ borderRadius: "var(--radius)" }} />
                      <span className="block h-1.5 w-3/5 bg-[var(--border)]" style={{ borderRadius: "var(--radius)" }} />
                    </div>
                  </div>
                ))}
              </div>
              <div className="mx-5 mb-5 flex items-center justify-between border border-[var(--border)] bg-[var(--panel2)] px-4 py-3" style={{ borderRadius: "var(--radius)" }}>
                <span className="h-2 w-24 bg-[var(--border2)]" style={{ borderRadius: "var(--radius)" }} />
                <span className="h-6 w-16 bg-[var(--accent)]" style={{ borderRadius: "var(--radius)" }} />
              </div>
            </div>
          </Reveal>

          {/* ── Tokens ── */}
          <div className="lg:col-span-7">
            <Reveal delay={120}>
              <p className="font-mono text-[11px] uppercase tracking-[0.22em] text-[var(--muted)]">§5.2 · Tokens visuales · defaults de la agencia</p>
              <div className="mt-4 grid gap-3 sm:grid-cols-2">
                {TOKENS_COLOR.map((t, i) => (
                  <Reveal key={t.v} delay={i * 70} className="card card-hover group flex items-center gap-4 p-4">
                    <span
                      className="h-12 w-12 shrink-0 border border-[var(--border2)] transition-transform duration-300 group-hover:scale-105 group-hover:-rotate-3"
                      style={{ background: t.swatch, borderRadius: "calc(var(--radius) - 2px)" }}
                    />
                    <span className="min-w-0">
                      <code className="block truncate font-mono text-[13px] font-semibold text-[var(--accent)]">{t.v}</code>
                      <code className="block truncate font-mono text-[11px] text-[var(--muted)]">{t.val}</code>
                      <span className="block text-[11px] text-[var(--faint)]">{t.desc}</span>
                    </span>
                  </Reveal>
                ))}
                <div className="card p-4 sm:col-span-2">
                  <ul className="grid gap-x-8 gap-y-2.5 sm:grid-cols-2">
                    {TOKENS_MISC.map((t) => (
                      <li key={t.v} className="flex items-baseline justify-between gap-4 border-b border-dashed border-[var(--border)] pb-2">
                        <code className="font-mono text-[12px] font-semibold text-[var(--accent2)]">{t.v}</code>
                        <span className="truncate text-right font-mono text-[11px] text-[var(--muted)]" title={t.val}>{t.val}</span>
                      </li>
                    ))}
                  </ul>
                  <p className="mt-3 font-mono text-[10px] uppercase tracking-[0.18em] text-[var(--faint)]">
                    preset «oscuro» = tokens actuales de TuboMax
                  </p>
                </div>
              </div>
            </Reveal>
          </div>
        </div>

        {/* ── §5.3 Interacción ── */}
        <div className="mt-16">
          <Reveal>
            <div className="mb-6 flex flex-wrap items-baseline justify-between gap-3">
              <h3 className="font-display text-xl uppercase tracking-tight sm:text-2xl">§5.3 · Hover-intent y movimiento</h3>
              <p className="font-mono text-[11px] text-[var(--faint)]">anim: --tbmx-anim · .22s cubic-bezier(.22,.61,.36,1)</p>
            </div>
          </Reveal>
          <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {INTERACTION.map((it, i) => (
              <Reveal key={it.k} delay={i * 90} className="card card-hover p-5">
                <p className="font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--muted)]">{it.k}</p>
                <p className="mt-2 font-display text-2xl text-[var(--accent)]">{it.v}</p>
                <p className="mt-2 text-[13px] leading-relaxed text-[var(--muted)]">{it.d}</p>
              </Reveal>
            ))}
          </div>
          <Reveal delay={160} className="card mt-4 p-5 sm:p-6">
            <p className="font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--faint)]">diagrama de intención · el panel solo abre si el cursor se queda</p>
            <div className="mt-4 space-y-4">
              <div>
                <div className="mb-1.5 flex justify-between font-mono text-[11px] text-[var(--muted)]">
                  <span>mouseenter → panel abierto</span><span className="text-[var(--accent)]">120 ms</span>
                </div>
                <div className="h-2 overflow-hidden bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }}>
                  <span className="intent-bar block h-full w-full bg-[var(--accent)]" />
                </div>
              </div>
              <div>
                <div className="mb-1.5 flex justify-between font-mono text-[11px] text-[var(--muted)]">
                  <span>mouseleave → panel cerrado</span><span className="text-[var(--accent2)]">200 ms</span>
                </div>
                <div className="h-2 overflow-hidden bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }}>
                  <span className="intent-bar block h-full w-full bg-[var(--accent2)]" style={{ animationDelay: "-1.7s" }} />
                </div>
              </div>
            </div>
            <p className="mt-4 text-[13px] text-[var(--muted)]">
              Fade + translateY(6–10 px) al abrir, con <code className="font-mono text-[var(--fg)]">prefers-reduced-motion</code> respetado. Este mismo header que estás usando aplica estos retardos.
            </p>
          </Reveal>
        </div>

        {/* ── §5.4 Responsive ── */}
        <div className="mt-16 grid gap-6 md:grid-cols-2">
          <Reveal className="card card-hover p-6 sm:p-7">
            <div className="flex items-center justify-between">
              <p className="font-display text-lg uppercase">Escritorio</p>
              <span className="font-mono text-[11px] uppercase tracking-widest text-[var(--ok)]">≥ 980 px</span>
            </div>
            <div className="mt-5 border border-[var(--border2)] p-3" style={{ borderRadius: "var(--radius)" }}>
              <div className="flex items-center gap-2 border-b border-[var(--border)] pb-2">
                <span className="h-2 w-10 bg-[var(--accent)]" style={{ borderRadius: "var(--radius)" }} />
                <span className="h-1.5 w-8 bg-[var(--border2)]" />
                <span className="h-1.5 w-8 bg-[var(--border2)]" />
                <span className="h-1.5 w-8 bg-[var(--border2)]" />
              </div>
              <div className="mt-2 grid grid-cols-4 gap-2">
                {[0, 1, 2, 3].map((i) => (
                  <span key={i} className="h-8 bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }} />
                ))}
              </div>
            </div>
            <p className="mt-4 text-[13px] leading-relaxed text-[var(--muted)]">
              Panel a sangre completa o limitado al contenedor, con hover-intent, click y teclado. Un solo panel abierto a la vez.
            </p>
          </Reveal>
          <Reveal delay={120} className="card card-hover p-6 sm:p-7">
            <div className="flex items-center justify-between">
              <p className="font-display text-lg uppercase">Móvil</p>
              <span className="font-mono text-[11px] uppercase tracking-widest text-[var(--accent)]">&lt; 980 px</span>
            </div>
            <div className="mt-5 flex justify-center">
              <div className="w-32 border border-[var(--border2)] p-2.5" style={{ borderRadius: "var(--radius)" }}>
                <div className="flex items-center justify-between border-b border-[var(--border)] pb-2">
                  <span className="h-2 w-8 bg-[var(--accent)]" style={{ borderRadius: "var(--radius)" }} />
                  <span className="flex flex-col gap-[3px]"><span className="h-[2px] w-4 bg-[var(--fg)]" /><span className="h-[2px] w-4 bg-[var(--fg)]" /><span className="h-[2px] w-4 bg-[var(--fg)]" /></span>
                </div>
                <div className="mt-2 space-y-1.5">
                  <span className="block h-3 bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }} />
                  <span className="ml-3 block h-3 w-4/5 bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }} />
                  <span className="ml-3 block h-3 w-3/5 bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }} />
                  <span className="block h-3 bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }} />
                </div>
              </div>
            </div>
            <p className="mt-4 text-[13px] leading-relaxed text-[var(--muted)]">
              Hamburguesa + acordeón vertical: el padre expande/colapsa su contenido. Nada de hover — todo por tap. El destacado va al final o se oculta (configurable).
            </p>
          </Reveal>
        </div>
      </div>
    </section>
  );
}

