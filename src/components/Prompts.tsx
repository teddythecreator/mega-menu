import { CLAUDE_MD, PHASE_PROMPTS } from "../lib/data";
import { CopyBtn, IconDoc, Reveal, SectionHead } from "../lib/Shared";

export default function Prompts() {
  return (
    <section id="prompts" className="mx-auto max-w-[1240px] scroll-mt-28 px-4 py-20 sm:px-6 md:py-28">
      <SectionHead
        num="11"
        kicker="Prompts para Claude Code"
        title="Pegar, construir, verificar"
        lead="Primero CLAUDE.md en la raíz del repositorio para fijar las reglas del juego. Después, los ocho prompts por fase, uno a uno, en orden. Cada fase termina con su checklist de QA."
      />

      {/* CLAUDE.md */}
      <Reveal>
        <div className="overflow-hidden">
          <div className="flex flex-wrap items-center justify-between gap-3 border border-b-0 border-[var(--border)] bg-[var(--panel2)] px-5 py-3" style={{ borderRadius: "var(--radius) var(--radius) 0 0" }}>
            <p className="flex items-center gap-2.5 font-mono text-xs uppercase tracking-widest text-[var(--muted)]">
              <IconDoc className="h-4 w-4 text-[var(--accent)]" />
              CLAUDE.md <span className="text-[var(--faint)]">· raíz del repo · va primero</span>
            </p>
            <CopyBtn text={CLAUDE_MD} />
          </div>
          <div className="code-slab max-h-[430px] overflow-auto p-5 text-[12.5px] leading-relaxed" style={{ borderRadius: "0 0 var(--radius) var(--radius)" }}>
            <pre className="whitespace-pre-wrap">{CLAUDE_MD}</pre>
          </div>
        </div>
      </Reveal>

      {/* 8 prompts por fase */}
      <div className="mt-10 grid gap-5 md:grid-cols-2">
        {PHASE_PROMPTS.map((p, i) => (
          <Reveal key={p.title} delay={(i % 2) * 100}>
            <div className="card card-hover group flex h-full flex-col p-6">
              <div className="flex items-start justify-between gap-4">
                <p className="flex items-baseline gap-3">
                  <span className="font-display text-2xl text-[var(--accent)]">{String(i + 1).padStart(2, "0")}</span>
                  <span className="font-display text-base uppercase tracking-tight">{p.title}</span>
                </p>
                <CopyBtn text={p.prompt} />
              </div>
              <p className="mt-4 flex-1 font-mono text-[12.5px] leading-relaxed text-[var(--muted)] transition-colors duration-200 group-hover:text-[var(--fg)]">
                “{p.prompt}”
              </p>
              <p className="mt-4 border-t border-[var(--border)] pt-3 font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--faint)]">
                {[0, 1, 1, 2, 2, 3, 3, 4][i] === 4 ? "QA final · contra el checklist §9" : `fase ${[0, 1, 1, 2, 2, 3, 3, 4][i]} · entregable por archivo`}
              </p>
            </div>
          </Reveal>
        ))}
      </div>
    </section>
  );
}
