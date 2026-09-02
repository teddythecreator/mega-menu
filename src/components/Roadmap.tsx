import { useEffect, useMemo, useState } from "react";
import { QA_ITEMS, ROADMAP } from "../lib/data";
import { IconCheck, Reveal, SectionHead } from "../lib/Shared";

/* Hook: conjunto persistente en localStorage */
export function usePersistentSet(key: string) {
  const [set, setSet] = useState<Set<string>>(() => {
    try {
      const raw = localStorage.getItem(key);
      return raw ? new Set<string>(JSON.parse(raw) as string[]) : new Set<string>();
    } catch {
      return new Set<string>();
    }
  });
  useEffect(() => {
    try {
      localStorage.setItem(key, JSON.stringify([...set]));
    } catch {
      /* almacenamiento no disponible: seguimos sin persistir */
    }
  }, [key, set]);
  const toggle = (id: string) =>
    setSet((prev) => {
      const next = new Set(prev);
      if (next.has(id)) next.delete(id);
      else next.add(id);
      return next;
    });
  const clear = () => setSet(new Set());
  return { set, toggle, clear };
}

export function CheckItem({ checked, onToggle, children }: { checked: boolean; onToggle: () => void; children: string }) {
  return (
    <li>
      <button
        onClick={onToggle}
        role="checkbox"
        aria-checked={checked}
        className="group flex w-full items-start gap-3 py-2 text-left"
      >
        <span
          className={`mt-0.5 flex h-[18px] w-[18px] shrink-0 items-center justify-center border transition-all duration-200 ${
            checked
              ? "border-[var(--accent)] bg-[var(--accent)] text-white"
              : "border-[var(--border2)] bg-transparent text-transparent group-hover:border-[var(--accent)]"
          }`}
          style={{ borderRadius: "calc(var(--radius) - 6px)" }}
        >
          <IconCheck className="h-3 w-3" />
        </span>
        <span
          className={`text-[14px] leading-relaxed transition-all duration-200 ${
            checked ? "text-[var(--faint)] line-through" : "text-[var(--muted)] group-hover:text-[var(--fg)]"
          }`}
        >
          {children}
        </span>
      </button>
    </li>
  );
}

export function MiniBar({ pct }: { pct: number }) {
  return (
    <span className="inline-block h-1.5 w-24 overflow-hidden bg-[var(--panel2)] align-middle" style={{ borderRadius: "var(--radius)" }}>
      <span className="prog-fill block h-full bg-[var(--accent)]" style={{ width: `${pct}%` }} />
    </span>
  );
}

export default function Roadmap() {
  const road = usePersistentSet("tbmx-roadmap-v1");
  const qa = usePersistentSet("tbmx-qa-v1");

  const roadTotal = useMemo(() => ROADMAP.reduce((a, f) => a + f.items.length, 0), []);
  const roadDone = useMemo(() => {
    let n = 0;
    ROADMAP.forEach((f, fi) => f.items.forEach((_, ii) => road.set.has(`r${fi}-${ii}`) && n++));
    return n;
  }, [road.set]);
  const qaDone = QA_ITEMS.filter((_, i) => qa.set.has(`q${i}`)).length;
  const pct = Math.round((roadDone / roadTotal) * 100);

  return (
    <section id="roadmap" className="scroll-mt-28 border-t border-[var(--border)] bg-[var(--bg2)]/60">
      <div className="mx-auto max-w-[1240px] px-4 py-20 sm:px-6 md:py-28">
        <SectionHead
          num="10"
          kicker="Roadmap con checklist"
          title="Marca cada caja"
          lead="El progreso se guarda en tu navegador: puedes cerrar el documento y retomarlo donde lo dejaste. Es el mismo checklist que seguirá el build con Claude Code."
        />

        {/* Progreso global */}
        <Reveal>
          <div className="card mb-10 flex flex-wrap items-center gap-x-10 gap-y-5 p-6 sm:p-7">
            <div>
              <p className="font-mono text-[10px] uppercase tracking-[0.22em] text-[var(--muted)]">Progreso global · fases 0–4</p>
              <p className="mt-1 font-display text-5xl leading-none">
                {pct}<span className="text-2xl text-[var(--accent)]">%</span>
              </p>
            </div>
            <div className="min-w-[220px] flex-1">
              <div className="h-3 overflow-hidden border border-[var(--border)] bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }}>
                <div className="prog-fill h-full bg-[var(--accent)]" style={{ width: `${pct}%` }} />
              </div>
              <p className="mt-2 font-mono text-[11px] uppercase tracking-widest text-[var(--muted)]">
                {roadDone} / {roadTotal} tareas completadas
              </p>
            </div>
            <button
              onClick={road.clear}
              className="border border-[var(--border2)] px-4 py-2 font-mono text-[11px] uppercase tracking-widest text-[var(--muted)] transition-colors duration-200 hover:border-[var(--accent)] hover:text-[var(--accent)]"
              style={{ borderRadius: "var(--radius)" }}
            >
              Reiniciar
            </button>
          </div>
        </Reveal>

        {/* Fases */}
        <div className="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
          {ROADMAP.map((f, fi) => {
            const done = f.items.filter((_, ii) => road.set.has(`r${fi}-${ii}`)).length;
            const fpct = Math.round((done / f.items.length) * 100);
            return (
              <Reveal key={f.fase} delay={(fi % 3) * 90} className={fi === 4 ? "md:col-span-2 xl:col-span-1" : ""}>
                <div className={`card h-full p-6 ${fpct === 100 ? "border-[var(--ok)]" : ""}`}>
                  <div className="flex items-center justify-between gap-3">
                    <p className="font-display text-base uppercase tracking-tight">{f.fase}</p>
                    <span className={`font-mono text-[11px] ${fpct === 100 ? "text-[var(--ok)]" : "text-[var(--muted)]"}`}>{done}/{f.items.length}</span>
                  </div>
                  <div className="mt-3"><MiniBar pct={fpct} /></div>
                  <ul className="mt-3 divide-y divide-[var(--border)]">
                    {f.items.map((it, ii) => (
                      <CheckItem key={it} checked={road.set.has(`r${fi}-${ii}`)} onToggle={() => road.toggle(`r${fi}-${ii}`)}>
                        {it}
                      </CheckItem>
                    ))}
                  </ul>
                </div>
              </Reveal>
            );
          })}

          {/* QA §9 */}
          <Reveal delay={180} className="md:col-span-2">
            <div className="card h-full border-l-2 border-l-[var(--accent2)] p-6">
              <div className="flex flex-wrap items-center justify-between gap-3">
                <p className="font-display text-base uppercase tracking-tight">
                  <span className="text-[var(--accent2)]">§9</span> · QA — checklist de pruebas
                </p>
                <span className="font-mono text-[11px] text-[var(--muted)]">{qaDone}/{QA_ITEMS.length} superadas</span>
              </div>
              <div className="mt-3"><MiniBar pct={Math.round((qaDone / QA_ITEMS.length) * 100)} /></div>
              <ul className="mt-3 grid gap-x-8 sm:grid-cols-2">
                {QA_ITEMS.map((it, i) => (
                  <CheckItem key={it} checked={qa.set.has(`q${i}`)} onToggle={() => qa.toggle(`q${i}`)}>
                    {it}
                  </CheckItem>
                ))}
              </ul>
              <button
                onClick={qa.clear}
                className="mt-2 font-mono text-[10px] uppercase tracking-widest text-[var(--faint)] underline decoration-dashed underline-offset-4 hover:text-[var(--accent)]"
              >
                reiniciar QA
              </button>
            </div>
          </Reveal>
        </div>
      </div>
    </section>
  );
}
