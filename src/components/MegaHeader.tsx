import { useEffect, useRef, useState } from "react";
import { IconArrow, IconChevron, IconMenu, IconX, LogoMark } from "../lib/Shared";

type MegaId = "producto" | "arquitectura" | "fases";

type PanelLink = { label: string; desc: string; href: string };

const MEGA: {
  id: MegaId;
  label: string;
  links: PanelLink[];
  kind: "featured" | "stack" | "cols";
}[] = [
  {
    id: "producto",
    label: "Producto",
    kind: "featured",
    links: [
      { label: "La recomendación", desc: "Por qué un plugin y no un snippet", href: "#resumen" },
      { label: "Decisión de arquitectura", desc: "La matriz de opciones y el veredicto", href: "#decision" },
      { label: "Definición de producto", desc: "Promesa, público y modelo", href: "#producto" },
      { label: "Distribución y licencia", desc: "GPL, tiers y canal de venta", href: "#licencia" },
    ],
  },
  {
    id: "arquitectura",
    label: "Arquitectura",
    kind: "stack",
    links: [
      { label: "Stack tecnológico", desc: "PHP 8 + JS vanilla + CSS vars", href: "#stack" },
      { label: "Estructura de archivos", desc: "El árbol completo del plugin", href: "#archivos" },
      { label: "Modelo de datos", desc: "Siete metas sobre nav_menu_item", href: "#datos" },
      { label: "Pipeline de render", desc: "Del enqueue al ARIA en 4 pasos", href: "#pipeline" },
    ],
  },
  {
    id: "fases",
    label: "Fases",
    kind: "cols",
    links: [
      { label: "MVP · v0.1", desc: "Metabox, render, tokens, acordeón y ARIA", href: "#fases" },
      { label: "v1.0 · Producto", desc: "Ajustes globales, presets, i18n", href: "#fases" },
      { label: "v2.0 · Diferenciación", desc: "Builder propio, tabs, WooCommerce", href: "#fases" },
    ],
  },
];

const PLAIN = [
  { label: "Roadmap", href: "#roadmap" },
  { label: "Prompts", href: "#prompts" },
  { label: "Licencia", href: "#licencia" },
];

const HOVER_IN = 120;
const HOVER_OUT = 200;

export default function MegaHeader() {
  const [open, setOpen] = useState<MegaId | null>(null);
  const [mobile, setMobile] = useState(false);
  const [acc, setAcc] = useState<MegaId | null>(null);
  const headerRef = useRef<HTMLElement>(null);
  const inT = useRef<number | undefined>(undefined);
  const outT = useRef<number | undefined>(undefined);
  const btnRefs = useRef<Partial<Record<MegaId, HTMLButtonElement | null>>>({});

  const scheduleOpen = (id: MegaId) => {
    window.clearTimeout(outT.current);
    window.clearTimeout(inT.current);
    inT.current = window.setTimeout(() => setOpen(id), HOVER_IN);
  };
  const scheduleClose = () => {
    window.clearTimeout(inT.current);
    window.clearTimeout(outT.current);
    outT.current = window.setTimeout(() => setOpen(null), HOVER_OUT);
  };
  const cancelClose = () => window.clearTimeout(outT.current);

  useEffect(() => {
    const onKey = (e: KeyboardEvent) => {
      if (e.key === "Escape") {
        setOpen((cur) => {
          if (cur) btnRefs.current[cur]?.focus();
          return null;
        });
        setMobile(false);
      }
    };
    const onDown = (e: PointerEvent) => {
      if (headerRef.current && !headerRef.current.contains(e.target as Node)) setOpen(null);
    };
    document.addEventListener("keydown", onKey);
    document.addEventListener("pointerdown", onDown);
    return () => {
      document.removeEventListener("keydown", onKey);
      document.removeEventListener("pointerdown", onDown);
      window.clearTimeout(inT.current);
      window.clearTimeout(outT.current);
    };
  }, []);

  const toggle = (id: MegaId) => {
    window.clearTimeout(inT.current);
    window.clearTimeout(outT.current);
    setOpen((cur) => (cur === id ? null : id));
  };

  return (
    <header ref={headerRef} className="sticky top-0 z-50 border-b border-[var(--border)] bg-[var(--bg)]/92 backdrop-blur-md">
      {/* ── Barra ── */}
      <div className="mx-auto flex h-16 max-w-[1240px] items-center justify-between gap-4 px-4 sm:px-6">
        <a href="#top" className="group flex items-center gap-3" aria-label="Volver arriba">
          <LogoMark className="h-8 w-8 text-[var(--fg)] transition-transform duration-300 group-hover:-rotate-6" />
          <span className="leading-none">
            <span className="block font-display text-[15px] tracking-wide">TBMX·MEGAMENU</span>
            <span className="mt-1 block font-mono text-[10px] uppercase tracking-[0.24em] text-[var(--muted)]">
              para Divi · doc maestro
            </span>
          </span>
        </a>

        {/* Nav escritorio */}
        <nav aria-label="Principal" className="hidden items-center gap-1 md:flex">
          {MEGA.map((m) => (
            <div key={m.id} onMouseEnter={() => scheduleOpen(m.id)} onMouseLeave={scheduleClose}>
              <button
                ref={(el) => {
                  btnRefs.current[m.id] = el;
                }}
                onClick={() => toggle(m.id)}
                aria-haspopup="true"
                aria-expanded={open === m.id}
                aria-controls={`panel-${m.id}`}
                className={`relative flex items-center gap-1.5 px-3.5 py-2 font-mono text-[13px] tracking-wide transition-colors duration-200 ${
                  open === m.id ? "text-[var(--fg)]" : "text-[var(--muted)] hover:text-[var(--fg)]"
                }`}
              >
                {m.label}
                <IconChevron
                  className={`h-3.5 w-3.5 transition-transform duration-300 ${open === m.id ? "rotate-180 text-[var(--accent)]" : ""}`}
                />
                <span
                  className={`absolute inset-x-3 -bottom-[1px] h-[2px] origin-left bg-[var(--accent)] transition-transform duration-300 ${
                    open === m.id ? "scale-x-100" : "scale-x-0"
                  }`}
                />
              </button>
            </div>
          ))}
          <span className="mx-2 h-5 w-px bg-[var(--border)]" aria-hidden="true" />
          {PLAIN.map((p) => (
            <a
              key={p.href}
              href={p.href}
              className="link-underline px-3.5 py-2 font-mono text-[13px] tracking-wide text-[var(--muted)] hover:text-[var(--fg)]"
            >
              {p.label}
            </a>
          ))}
        </nav>

        <div className="flex items-center gap-3">
          <span className="hidden items-center gap-2 border border-[var(--border)] px-2.5 py-1 font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--muted)] sm:inline-flex" style={{ borderRadius: "var(--radius)" }}>
            <span className="pulse-dot h-1.5 w-1.5 rounded-full bg-[var(--accent)]" />
            demo activa
          </span>
          <span className="border border-[var(--accent)] px-2.5 py-1 font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-[var(--accent)]" style={{ borderRadius: "var(--radius)" }}>
            v0.1
          </span>
          <button
            className="p-2 text-[var(--fg)] md:hidden"
            onClick={() => setMobile((v) => !v)}
            aria-expanded={mobile}
            aria-controls="drawer-mobile"
            aria-label={mobile ? "Cerrar menú" : "Abrir menú"}
          >
            {mobile ? <IconX /> : <IconMenu />}
          </button>
        </div>
      </div>

      {/* ── Paneles mega (escritorio) ── */}
      {MEGA.map((m) => (
        <div
          key={m.id}
          id={`panel-${m.id}`}
          role="region"
          aria-label={`Panel ${m.label}`}
          hidden={open !== m.id}
          onMouseEnter={cancelClose}
          onMouseLeave={scheduleClose}
          className={`mega-panel absolute inset-x-0 top-full hidden md:block ${open === m.id ? "panel-in" : ""}`}
        >
          <div className="mx-auto grid max-w-[1240px] gap-10 px-6 py-8 lg:py-10">
            {m.kind === "featured" && (
              <div className="grid gap-10 lg:grid-cols-12">
                <ul className="space-y-1 lg:col-span-5">
                  {m.links.map((l) => (
                    <PanelRow key={l.href} {...l} />
                  ))}
                </ul>
                <div className="lg:col-span-7">
                  <div className="card h-full border-l-2 border-l-[var(--accent)] bg-[var(--panel2)] p-6">
                    <p className="font-mono text-[10px] uppercase tracking-[0.24em] text-[var(--accent)]">¿Por qué esta vía?</p>
                    <p className="mt-3 font-display text-xl leading-snug uppercase">Un plugin, tres victorias</p>
                    <ul className="mt-4 space-y-2.5 text-sm text-[var(--muted)]">
                      <li><b className="text-[var(--fg)]">Reutilizable</b> — se instala en cada proyecto Divi de la agencia.</li>
                      <li><b className="text-[var(--fg)]">Vendible</b> — activo con licencia para el mercado de add-ons.</li>
                      <li><b className="text-[var(--fg)]">Esfuerzo controlado</b> — el panel se diseña con el propio Divi Builder.</li>
                    </ul>
                    <a href="#resumen" className="group mt-5 inline-flex items-center gap-2 font-mono text-xs uppercase tracking-widest text-[var(--fg)]">
                      <span className="link-underline">Leer el resumen ejecutivo</span>
                      <IconArrow className="h-3.5 w-3.5 text-[var(--accent)] transition-transform duration-200 group-hover:translate-x-1" />
                    </a>
                  </div>
                </div>
              </div>
            )}
            {m.kind === "stack" && (
              <div className="grid gap-10 lg:grid-cols-12">
                <ul className="space-y-1 lg:col-span-5">
                  {m.links.map((l) => (
                    <PanelRow key={l.href + l.label} {...l} />
                  ))}
                </ul>
                <div className="lg:col-span-7">
                  <div className="flex flex-wrap gap-2">
                    {["PHP 8.x · APIs nativas", "JS vanilla < 5 KB", "CSS custom properties", "Sin jQuery"].map((c) => (
                      <span key={c} className="border border-[var(--border2)] px-3 py-1 font-mono text-[11px] text-[var(--muted)]" style={{ borderRadius: "var(--radius)" }}>
                        {c}
                      </span>
                    ))}
                  </div>
                  <div className="code-slab mt-4 p-4 text-[12px] leading-relaxed">
                    <p className="text-[var(--faint)]"># raíz del plugin</p>
                    <p><span className="text-[var(--accent2)]">tbmx-megamenu/</span></p>
                    <p className="pl-4">├─ class-menu-walker.php <span className="text-[var(--faint)]"># Walker + ARIA</span></p>
                    <p className="pl-4">├─ class-renderer.php <span className="text-[var(--faint)]"># layout Divi → panel</span></p>
                    <p className="pl-4">└─ js/megamenu.js <span className="text-[var(--faint)]"># hover-intent</span></p>
                  </div>
                  <p className="mt-3 font-mono text-[11px] text-[var(--muted)]">
                    <span className="text-[var(--ok)]">●</span> Enqueue condicional: 0 KB en páginas sin megamenú.
                  </p>
                </div>
              </div>
            )}
            {m.kind === "cols" && (
              <div>
                <div className="grid gap-8 md:grid-cols-3">
                  {m.links.map((l, i) => (
                    <div key={l.label} className="border-t-2 pt-4" style={{ borderColor: i === 0 ? "var(--accent)" : "var(--border2)" }}>
                      <p className="font-display text-lg uppercase">{l.label}</p>
                      <p className="mt-2 text-sm leading-relaxed text-[var(--muted)]">{l.desc}</p>
                      <a href={l.href} className="group mt-3 inline-flex items-center gap-2 font-mono text-[11px] uppercase tracking-widest text-[var(--muted)] hover:text-[var(--fg)]">
                        Ver alcance <IconArrow className="h-3 w-3 text-[var(--accent)] transition-transform group-hover:translate-x-1" />
                      </a>
                    </div>
                  ))}
                </div>
              </div>
            )}
            <p className="border-t border-[var(--border)] pt-4 font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--faint)]">
              demo del patrón disclosure · hover-intent {HOVER_IN}/{HOVER_OUT} ms · Esc cierra y devuelve el foco · un solo panel a la vez
            </p>
          </div>
        </div>
      ))}

      {/* ── Drawer móvil con acordeones ── */}
      <div id="drawer-mobile" hidden={!mobile} className={`border-t border-[var(--border)] bg-[var(--bg2)] md:hidden ${mobile ? "drawer-in" : ""}`}>
        <nav aria-label="Móvil" className="mx-auto max-w-[1240px] px-4 py-4 sm:px-6">
          {MEGA.map((m) => (
            <div key={m.id} className="border-b border-[var(--border)]">
              <button
                onClick={() => setAcc((a) => (a === m.id ? null : m.id))}
                aria-expanded={acc === m.id}
                className="flex w-full items-center justify-between py-3.5 font-mono text-sm tracking-wide text-[var(--fg)]"
              >
                {m.label}
                <IconChevron className={`h-4 w-4 text-[var(--accent)] transition-transform duration-300 ${acc === m.id ? "rotate-180" : ""}`} />
              </button>
              <div hidden={acc !== m.id} className="pb-4">
                <ul className="space-y-1 border-l-2 border-[var(--accent)] pl-4">
                  {m.links.map((l) => (
                    <li key={l.label + l.href}>
                      <a href={l.href} onClick={() => setMobile(false)} className="block py-1.5">
                        <span className="block text-sm font-medium">{l.label}</span>
                        <span className="block text-xs text-[var(--muted)]">{l.desc}</span>
                      </a>
                    </li>
                  ))}
                </ul>
              </div>
            </div>
          ))}
          {PLAIN.map((p) => (
            <a
              key={p.href}
              href={p.href}
              onClick={() => setMobile(false)}
              className="block border-b border-[var(--border)] py-3.5 font-mono text-sm tracking-wide text-[var(--muted)]"
            >
              {p.label}
            </a>
          ))}
          <p className="pt-4 font-mono text-[10px] uppercase tracking-[0.2em] text-[var(--faint)]">
            acordeón &lt; 980 px · sin hover en móvil: todo por tap
          </p>
        </nav>
      </div>
    </header>
  );
}

function PanelRow({ label, desc, href }: PanelLink) {
  return (
    <li>
      <a
        href={href}
        className="group flex items-start justify-between gap-4 px-3 py-2.5 transition-colors duration-200 hover:bg-[var(--panel2)]"
        style={{ borderRadius: "var(--radius)" }}
      >
        <span>
          <span className="block text-sm font-semibold text-[var(--fg)]">{label}</span>
          <span className="mt-0.5 block text-xs text-[var(--muted)]">{desc}</span>
        </span>
        <IconArrow className="mt-1 h-3.5 w-3.5 shrink-0 text-[var(--faint)] transition-all duration-200 group-hover:translate-x-1 group-hover:text-[var(--accent)]" />
      </a>
    </li>
  );
}
