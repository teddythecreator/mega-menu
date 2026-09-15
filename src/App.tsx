import { useEffect, useState } from "react";
import Business from "./components/Business";
import Cover from "./components/Cover";
import Design from "./components/Design";
import MegaHeader from "./components/MegaHeader";
import Phases from "./components/Phases";
import Prompts from "./components/Prompts";
import QAChecklist from "./components/QAChecklist";
import Quality from "./components/Quality";
import Roadmap from "./components/Roadmap";
import Tech from "./components/Tech";
import { TICKER_ITEMS, type PresetId } from "./lib/data";
import { LogoMark, Ticker } from "./lib/Shared";

function usePreset() {
  const [preset, setPreset] = useState<PresetId>(() => {
    try {
      const v = localStorage.getItem("tbmx-preset-v1");
      if (v === "claro" || v === "minimal" || v === "oscuro") return v;
    } catch {
      /* sin almacenamiento */
    }
    return "oscuro";
  });
  useEffect(() => {
    try {
      localStorage.setItem("tbmx-preset-v1", preset);
    } catch {
      /* sin almacenamiento */
    }
  }, [preset]);
  return [preset, setPreset] as const;
}

function ScrollProgress() {
  const [p, setP] = useState(0);
  useEffect(() => {
    let raf = 0;
    const on = () => {
      cancelAnimationFrame(raf);
      raf = requestAnimationFrame(() => {
        const h = document.documentElement;
        const max = h.scrollHeight - h.clientHeight;
        setP(max > 0 ? (h.scrollTop / max) * 100 : 0);
      });
    };
    on();
    window.addEventListener("scroll", on, { passive: true });
    window.addEventListener("resize", on);
    return () => {
      window.removeEventListener("scroll", on);
      window.removeEventListener("resize", on);
      cancelAnimationFrame(raf);
    };
  }, []);
  return <div aria-hidden="true" className="fixed left-0 top-0 z-[70] h-[3px] bg-[var(--accent)] transition-[width] duration-150 ease-out" style={{ width: `${p}%` }} />;
}

const FOOTER_INDEX = [
  ["§0 · Resumen", "#resumen"],
  ["§1 · Decisión", "#decision"],
  ["§3 · Fases", "#fases"],
  ["§4 · Arquitectura", "#arquitectura"],
  ["§5 · Diseño / UX", "#diseno"],
  ["§6–8 · Calidad", "#calidad"],
  ["§10 · Roadmap", "#roadmap"],
  ["§11 · Prompts", "#prompts"],
  ["§12 · Licencia", "#licencia"],
  ["§13 · Nombre", "#nombre"],
];

function Footer() {
  return (
    <footer className="border-t border-[var(--border)] bg-[var(--bg2)]">
      <div className="mx-auto grid max-w-[1240px] gap-10 px-4 py-14 sm:px-6 md:grid-cols-12">
        <div className="md:col-span-5">
          <a href="#top" className="flex items-center gap-3">
            <LogoMark className="h-9 w-9 text-[var(--fg)]" />
            <span className="leading-none">
              <span className="block font-display text-base tracking-wide">TBMX·MEGAMENU</span>
              <span className="mt-1 block font-mono text-[10px] uppercase tracking-[0.24em] text-[var(--muted)]">documento maestro</span>
            </span>
          </a>
          <p className="mt-5 max-w-sm text-[13px] leading-relaxed text-[var(--muted)]">
            Fuente única de verdad para construir el plugin con Claude Code en otra máquina.
            Si el documento y el código discrepan, <b className="text-[var(--fg)]">el documento se actualiza</b> — es un borrador vivo.
          </p>
        </div>
        <div className="md:col-span-4">
          <p className="font-mono text-[10px] uppercase tracking-[0.24em] text-[var(--faint)]">Índice</p>
          <ul className="mt-4 grid grid-cols-2 gap-x-6 gap-y-2">
            {FOOTER_INDEX.map(([l, h]) => (
              <li key={h}>
                <a href={h} className="link-underline font-mono text-[12px] text-[var(--muted)] hover:text-[var(--fg)]">{l}</a>
              </li>
            ))}
          </ul>
        </div>
        <div className="md:col-span-3">
          <p className="font-mono text-[10px] uppercase tracking-[0.24em] text-[var(--faint)]">Meta</p>
          <dl className="mt-4 space-y-2.5 font-mono text-[12px]">
            <div className="flex justify-between gap-4"><dt className="text-[var(--muted)]">rev</dt><dd>v0.1</dd></div>
            <div className="flex justify-between gap-4"><dt className="text-[var(--muted)]">estado</dt><dd className="flex items-center gap-2"><span className="pulse-dot h-1.5 w-1.5 rounded-full bg-[var(--ok)]" />borrador vivo</dd></div>
            <div className="flex justify-between gap-4"><dt className="text-[var(--muted)]">secciones</dt><dd>§0 – §13</dd></div>
            <div className="flex justify-between gap-4"><dt className="text-[var(--muted)]">build target</dt><dd>WP + Divi</dd></div>
          </dl>
        </div>
      </div>
      <div className="border-t border-[var(--border)]">
        <div className="mx-auto flex max-w-[1240px] flex-wrap items-center justify-between gap-3 px-4 py-5 sm:px-6">
          <p className="font-mono text-[11px] uppercase tracking-[0.18em] text-[var(--faint)]">
            TBMX · doc-maestro v0.1 — actualizar a medida que avances
          </p>
          <a href="#top" className="link-underline font-mono text-[11px] uppercase tracking-[0.18em] text-[var(--muted)] hover:text-[var(--fg)]">
            ↑ volver arriba
          </a>
        </div>
      </div>
    </footer>
  );
}

export default function App() {
  const [preset, setPreset] = usePreset();
  useEffect(() => {
    document.documentElement.dataset.preset = preset;
  }, [preset]);

  return (
    <div className="relative min-h-screen">
      <ScrollProgress />

      {/* fondo ambiental por capas */}
      <div aria-hidden="true" className="pointer-events-none fixed inset-0 z-0">
        <div className="amb-grid absolute inset-0" />
        <div className="amb-glow absolute inset-0" />
        <div className="amb-noise absolute inset-0" />
      </div>

      <div className="relative z-10">
        <MegaHeader />

        {/* franja de la demo */}
        <div className="border-b border-[var(--border)] bg-[var(--bg2)]/85">
          <p className="mx-auto flex max-w-[1240px] flex-wrap items-center gap-x-7 gap-y-1 px-4 py-2 font-mono text-[10px] uppercase tracking-[0.16em] text-[var(--muted)] sm:px-6 sm:text-[11px]">
            <span className="flex items-center gap-2">
              <span className="pulse-dot h-1.5 w-1.5 rounded-full bg-[var(--accent)]" />
              estás navegando el patrón disclosure del plugin
            </span>
            <span>Tab hasta un disparador · Enter abre · Esc cierra</span>
            <span className="max-md:hidden">&lt; 980 px → hamburguesa + acordeón</span>
          </p>
        </div>

        <main>
          <Cover />
          <Ticker items={TICKER_ITEMS} />
          <Tech />
          <Phases />
          <Design preset={preset} onPreset={setPreset} />
          <Quality />
          <Roadmap />
          <QAChecklist />
          <Prompts />
          <Business />
        </main>

        <Footer />
      </div>
    </div>
  );
}
