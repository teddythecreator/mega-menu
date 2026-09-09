import { useMemo, useState } from "react";
import { QA_ACCEPTANCE, QA_CATEGORIES, QA_TOTAL } from "../lib/qa-data";
import { IconCheck, Reveal, SectionHead } from "../lib/Shared";
import { CheckItem, usePersistentSet } from "./Roadmap";

type Filter = "all" | "pending" | "done";

export default function QAChecklist() {
  const qa = usePersistentSet("tbmx-qa-full-v1");
  const [filter, setFilter] = useState<Filter>("all");
  const [expandedCat, setExpandedCat] = useState<string | null>(QA_CATEGORIES[0].id);

  // Estadísticas globales
  const stats = useMemo(() => {
    const total = QA_TOTAL;
    const done = Array.from(qa.set).length;
    const pct = total > 0 ? Math.round((done / total) * 100) : 0;
    const status =
      pct >= QA_ACCEPTANCE.pass
        ? { label: "Aprobado", color: "var(--ok)", icon: "✓" }
        : pct >= QA_ACCEPTANCE.conditional
        ? { label: "Condicional", color: "var(--accent2)", icon: "⚠" }
        : { label: "Pendiente", color: "var(--accent)", icon: "●" };
    return { total, done, pct, status };
  }, [qa.set]);

  // Estadísticas por categoría
  const catStats = useMemo(() => {
    return QA_CATEGORIES.map((cat) => {
      const catTotal = cat.groups.reduce((a, g) => a + g.items.length, 0);
      let catDone = 0;
      cat.groups.forEach((g, gi) => {
        g.items.forEach((_, ii) => {
          if (qa.set.has(`${cat.id}-${gi}-${ii}`)) catDone++;
        });
      });
      const pct = catTotal > 0 ? Math.round((catDone / catTotal) * 100) : 0;
      return { id: cat.id, total: catTotal, done: catDone, pct };
    });
  }, [qa.set]);

  const toggle = (catId: string, gi: number, ii: number) => {
    qa.toggle(`${catId}-${gi}-${ii}`);
  };

  const toggleCategory = (catId: string) => {
    setExpandedCat((cur) => (cur === catId ? null : catId));
  };



  return (
    <section id="qa-checklist" className="scroll-mt-28 border-t border-[var(--border)] bg-[var(--bg2)]/60">
      <div className="mx-auto max-w-[1240px] px-4 py-20 sm:px-6 md:py-28">
        <SectionHead
          num="QA"
          kicker="Checklist de pruebas interactivo"
          title="309 pruebas, 12 categorías"
          lead="Marca cada prueba conforme la valides. El progreso se guarda en tu navegador. El criterio de aceptación es 95% de pruebas pasadas para aprobar, 85-94% para aprobación condicional."
        />

        {/* ── Panel de progreso global ── */}
        <Reveal>
          <div className="card mb-8 overflow-hidden">
            <div className="grid gap-6 p-6 sm:p-8 md:grid-cols-12">
              {/* Score principal */}
              <div className="md:col-span-4">
                <p className="font-mono text-[10px] uppercase tracking-[0.24em] text-[var(--faint)]">Resultado actual</p>
                <div className="mt-2 flex items-baseline gap-3">
                  <span className="font-display text-6xl leading-none" style={{ color: stats.status.color }}>
                    {stats.pct}
                  </span>
                  <span className="font-display text-2xl text-[var(--muted)]">%</span>
                </div>
                <div className="mt-3 flex items-center gap-2">
                  <span
                    className="inline-flex items-center gap-1.5 px-2.5 py-1 font-mono text-[10px] font-semibold uppercase tracking-[0.16em] text-white"
                    style={{ background: stats.status.color, borderRadius: "var(--radius)" }}
                  >
                    {stats.status.icon} {stats.status.label}
                  </span>
                  <span className="font-mono text-[11px] text-[var(--muted)]">
                    {stats.done} / {stats.total}
                  </span>
                </div>
              </div>

              {/* Barra de progreso con umbrales */}
              <div className="md:col-span-8">
                <div className="mb-2 flex justify-between font-mono text-[10px] uppercase tracking-widest text-[var(--faint)]">
                  <span>0%</span>
                  <span className="text-[var(--accent2)]">Condicional · 85%</span>
                  <span className="text-[var(--ok)]">Aprobado · 95%</span>
                  <span>100%</span>
                </div>
                <div className="relative h-4 overflow-hidden border border-[var(--border)] bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }}>
                  <div
                    className="prog-fill absolute inset-y-0 left-0"
                    style={{
                      width: `${stats.pct}%`,
                      background: stats.status.color,
                    }}
                  />
                  {/* Marcadores de umbral */}
                  <span className="absolute inset-y-0 border-l-2 border-dashed border-[var(--accent2)]" style={{ left: "85%" }} />
                  <span className="absolute inset-y-0 border-l-2 border-dashed border-[var(--ok)]" style={{ left: "95%" }} />
                </div>
                <div className="mt-4 flex flex-wrap gap-3">
                  <button
                    onClick={() => setFilter("all")}
                    className={`px-3 py-1.5 font-mono text-[11px] uppercase tracking-widest transition-colors ${
                      filter === "all" ? "bg-[var(--fg)] text-[var(--bg)]" : "text-[var(--muted)] hover:text-[var(--fg)]"
                    }`}
                    style={{ borderRadius: "var(--radius)" }}
                  >
                    Todas ({stats.total})
                  </button>
                  <button
                    onClick={() => setFilter("pending")}
                    className={`px-3 py-1.5 font-mono text-[11px] uppercase tracking-widest transition-colors ${
                      filter === "pending" ? "bg-[var(--accent)] text-white" : "text-[var(--muted)] hover:text-[var(--fg)]"
                    }`}
                    style={{ borderRadius: "var(--radius)" }}
                  >
                    Pendientes ({stats.total - stats.done})
                  </button>
                  <button
                    onClick={() => setFilter("done")}
                    className={`px-3 py-1.5 font-mono text-[11px] uppercase tracking-widest transition-colors ${
                      filter === "done" ? "bg-[var(--ok)] text-white" : "text-[var(--muted)] hover:text-[var(--fg)]"
                    }`}
                    style={{ borderRadius: "var(--radius)" }}
                  >
                    Pasadas ({stats.done})
                  </button>
                  <button
                    onClick={() => {
                      if (confirm("¿Reiniciar todas las pruebas? Esta acción no se puede deshacer.")) {
                        qa.clear();
                      }
                    }}
                    className="ml-auto px-3 py-1.5 font-mono text-[11px] uppercase tracking-widest text-[var(--muted)] transition-colors hover:text-[var(--accent)]"
                    style={{ borderRadius: "var(--radius)" }}
                  >
                    Reiniciar
                  </button>
                </div>
              </div>
            </div>

            {/* Mini-stats por categoría */}
            <div className="grid grid-cols-2 gap-px border-t border-[var(--border)] bg-[var(--border)] sm:grid-cols-3 md:grid-cols-6">
              {catStats.map((cs, i) => {
                const cat = QA_CATEGORIES[i];
                return (
                  <button
                    key={cs.id}
                    onClick={() => toggleCategory(cs.id)}
                    className="bg-[var(--panel)] px-3 py-3 text-left transition-colors hover:bg-[var(--panel2)]"
                  >
                    <p className="flex items-center gap-1.5 font-mono text-[10px] uppercase tracking-widest text-[var(--muted)]">
                      <span>{cat.icon}</span>
                      <span className="truncate">{cat.title.split(" ")[0]}</span>
                    </p>
                    <p className="mt-1 font-display text-xl" style={{ color: cs.pct === 100 ? "var(--ok)" : cat.color }}>
                      {cs.pct}%
                    </p>
                    <p className="font-mono text-[9px] text-[var(--faint)]">
                      {cs.done}/{cs.total}
                    </p>
                  </button>
                );
              })}
            </div>
          </div>
        </Reveal>

        {/* ── Categorías expandibles ── */}
        <div className="space-y-3">
          {QA_CATEGORIES.map((cat, ci) => {
            const cs = catStats[ci];
            const isExpanded = expandedCat === cat.id;
            return (
              <Reveal key={cat.id} delay={ci * 40}>
                <div className="card overflow-hidden">
                  {/* Header de categoría */}
                  <button
                    onClick={() => toggleCategory(cat.id)}
                    className="flex w-full items-center gap-4 p-5 text-left transition-colors hover:bg-[var(--panel2)]"
                  >
                    <span className="text-2xl">{cat.icon}</span>
                    <div className="min-w-0 flex-1">
                      <p className="font-display text-base uppercase tracking-tight sm:text-lg">{cat.title}</p>
                      <p className="mt-0.5 font-mono text-[11px] text-[var(--muted)]">
                        {cs.done} de {cs.total} pruebas · {cat.groups.length} grupos
                      </p>
                    </div>
                    <div className="hidden items-center gap-3 sm:flex">
                      <div className="h-1.5 w-24 overflow-hidden bg-[var(--panel2)]" style={{ borderRadius: "var(--radius)" }}>
                        <div
                          className="prog-fill h-full"
                          style={{
                            width: `${cs.pct}%`,
                            background: cs.pct === 100 ? "var(--ok)" : cat.color,
                          }}
                        />
                      </div>
                      <span className="font-display text-sm" style={{ color: cs.pct === 100 ? "var(--ok)" : cat.color }}>
                        {cs.pct}%
                      </span>
                    </div>
                    <svg
                      viewBox="0 0 16 16"
                      className={`h-4 w-4 shrink-0 text-[var(--muted)] transition-transform duration-300 ${isExpanded ? "rotate-180" : ""}`}
                      fill="none"
                      stroke="currentColor"
                      strokeWidth="2"
                      strokeLinecap="round"
                    >
                      <path d="M4 6l4 4 4-4" />
                    </svg>
                  </button>

                  {/* Contenido expandible */}
                  <div hidden={!isExpanded} className="border-t border-[var(--border)] bg-[var(--panel2)]/40">
                    {cat.groups.map((group, gi) => {
                      const groupDone = group.items.filter((_, ii) => qa.set.has(`${cat.id}-${gi}-${ii}`)).length;
                      const groupPct = Math.round((groupDone / group.items.length) * 100);

                      // Filtrar items según el filtro activo
                      const visibleItems = group.items
                        .map((item, ii) => ({ item, ii, done: qa.set.has(`${cat.id}-${gi}-${ii}`) }))
                        .filter(({ done }) => {
                          if (filter === "pending") return !done;
                          if (filter === "done") return done;
                          return true;
                        });

                      if (visibleItems.length === 0) return null;

                      return (
                        <div key={gi} className="border-b border-[var(--border)] last:border-b-0">
                          <div className="flex flex-wrap items-center justify-between gap-3 bg-[var(--panel2)] px-5 py-2.5">
                            <p className="font-mono text-[11px] uppercase tracking-widest text-[var(--fg)]">
                              {group.title}
                            </p>
                            <div className="flex items-center gap-2">
                              <span className="font-mono text-[10px] text-[var(--muted)]">
                                {groupDone}/{group.items.length}
                              </span>
                              <div className="h-1 w-16 overflow-hidden bg-[var(--panel)]" style={{ borderRadius: "var(--radius)" }}>
                                <div
                                  className="prog-fill h-full"
                                  style={{
                                    width: `${groupPct}%`,
                                    background: groupPct === 100 ? "var(--ok)" : cat.color,
                                  }}
                                />
                              </div>
                            </div>
                          </div>
                          <ul className="divide-y divide-[var(--border)] px-5">
                            {visibleItems.map(({ item, ii, done }) => (
                              <CheckItem key={ii} checked={done} onToggle={() => toggle(cat.id, gi, ii)}>
                                {item}
                              </CheckItem>
                            ))}
                          </ul>
                        </div>
                      );
                    })}
                  </div>
                </div>
              </Reveal>
            );
          })}
        </div>

        {/* ── Criterios de aceptación ── */}
        <Reveal delay={200}>
          <div className="card mt-10 p-6 sm:p-8">
            <p className="font-display text-lg uppercase tracking-tight">Criterios de aceptación</p>
            <div className="mt-5 grid gap-4 sm:grid-cols-3">
              <div className="border-l-4 border-l-[var(--ok)] bg-[var(--panel2)] p-4" style={{ borderRadius: "var(--radius)" }}>
                <p className="font-mono text-[10px] uppercase tracking-widest text-[var(--ok)]">✓ Aprobado</p>
                <p className="mt-1 font-display text-2xl">{QA_ACCEPTANCE.pass}%+</p>
                <p className="mt-1 text-[13px] text-[var(--muted)]">Listo para distribución</p>
              </div>
              <div className="border-l-4 border-l-[var(--accent2)] bg-[var(--panel2)] p-4" style={{ borderRadius: "var(--radius)" }}>
                <p className="font-mono text-[10px] uppercase tracking-widest text-[var(--accent2)]">⚠ Condicional</p>
                <p className="mt-1 font-display text-2xl">{QA_ACCEPTANCE.conditional}–{QA_ACCEPTANCE.pass - 1}%</p>
                <p className="mt-1 text-[13px] text-[var(--muted)]">Requiere revisión</p>
              </div>
              <div className="border-l-4 border-l-[var(--accent)] bg-[var(--panel2)] p-4" style={{ borderRadius: "var(--radius)" }}>
                <p className="font-mono text-[10px] uppercase tracking-widest text-[var(--accent)]">✗ Rechazado</p>
                <p className="mt-1 font-display text-2xl">&lt; {QA_ACCEPTANCE.conditional}%</p>
                <p className="mt-1 text-[13px] text-[var(--muted)]">Correcciones necesarias</p>
              </div>
            </div>
          </div>
        </Reveal>

        {/* ── Severidad de bugs ── */}
        <Reveal delay={260}>
          <div className="card mt-6 p-6 sm:p-8">
            <p className="font-display text-lg uppercase tracking-tight">Prioridades de fallos</p>
            <div className="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
              {[
                { level: "Crítico", color: "#c0392b", desc: "Bloquea funcionalidad principal" },
                { level: "Alto", color: "#e67e22", desc: "Afecta UX significativamente" },
                { level: "Medio", color: "#f39c12", desc: "Problema menor, tiene workaround" },
                { level: "Bajo", color: "#27ae60", desc: "Cosmético o muy específico" },
              ].map((p) => (
                <div key={p.level} className="flex items-start gap-3 border border-[var(--border)] p-3" style={{ borderRadius: "var(--radius)" }}>
                  <span className="mt-1 h-3 w-3 shrink-0 rounded-full" style={{ background: p.color }} />
                  <div>
                    <p className="font-mono text-[11px] font-semibold uppercase tracking-widest" style={{ color: p.color }}>
                      {p.level}
                    </p>
                    <p className="mt-0.5 text-[12px] text-[var(--muted)]">{p.desc}</p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </Reveal>
      </div>
    </section>
  );
}
