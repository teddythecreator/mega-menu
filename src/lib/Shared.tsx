import { useEffect, useRef, useState, type ReactNode } from "react";

/* ── Movimiento ──────────────────────────────────────────────────── */

export function useReducedMotion() {
  const [reduced, setReduced] = useState(false);
  useEffect(() => {
    const mq = window.matchMedia("(prefers-reduced-motion: reduce)");
    setReduced(mq.matches);
    const fn = (e: MediaQueryListEvent) => setReduced(e.matches);
    mq.addEventListener("change", fn);
    return () => mq.removeEventListener("change", fn);
  }, []);
  return reduced;
}

export function Reveal({
  children,
  className = "",
  delay = 0,
  as: Tag = "div",
}: {
  children: ReactNode;
  className?: string;
  delay?: number;
  as?: "div" | "section" | "li" | "span" | "article";
}) {
  const ref = useRef<HTMLElement | null>(null);
  useEffect(() => {
    const el = ref.current;
    if (!el) return;
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            el.classList.add("is-in");
            io.disconnect();
          }
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -6% 0px" }
    );
    io.observe(el);
    return () => io.disconnect();
  }, []);
  return (
    <Tag ref={ref as never} className={`rv ${className}`} style={{ ["--rvd" as never]: `${delay}ms` }}>
      {children}
    </Tag>
  );
}

/* Título con revelado línea a línea (line-mask) */
export function MaskTitle({
  lines,
  className = "",
  step = 110,
}: {
  lines: ReactNode[];
  className?: string;
  step?: number;
}) {
  const ref = useRef<HTMLDivElement>(null);
  useEffect(() => {
    const el = ref.current;
    if (!el) return;
    const io = new IntersectionObserver(
      (es) => es.forEach((e) => e.isIntersecting && (el.classList.add("is-in"), io.disconnect())),
      { threshold: 0.25 }
    );
    io.observe(el);
    return () => io.disconnect();
  }, []);
  return (
    <div ref={ref} className={className}>
      {lines.map((l, i) => (
        <span key={i} className="mask-line">
          <span style={{ ["--mld" as never]: `${i * step}ms` }}>{l}</span>
        </span>
      ))}
    </div>
  );
}

/* ── Cabecera de sección ─────────────────────────────────────────── */
export function SectionHead({
  num,
  kicker,
  title,
  lead,
  id,
}: {
  num: string;
  kicker: string;
  title: string;
  lead?: string;
  id?: string;
}) {
  return (
    <Reveal className="mb-10 md:mb-14">
      <p className="font-mono text-[11px] sm:text-xs tracking-[0.22em] uppercase text-[var(--muted)]">
        <span className="text-[var(--accent)] font-semibold">§{num}</span>
        <span className="mx-3 text-[var(--faint)]">/</span>
        {kicker}
      </p>
      <MaskTitle
        className="mt-3 font-display text-[clamp(1.9rem,4.6vw,3.4rem)] leading-[1.02] tracking-tight uppercase"
        lines={[title]}
      />
      {lead && <p className="mt-4 max-w-2xl text-[15px] sm:text-base leading-relaxed text-[var(--muted)]">{lead}</p>}
      {id && <span id={id} className="block scroll-mt-28" />}
    </Reveal>
  );
}

/* ── Cinta corrediza ─────────────────────────────────────────────── */
export function Ticker({ items }: { items: string[] }) {
  const row = (ariaHidden: boolean) => (
    <div aria-hidden={ariaHidden} className="flex shrink-0 items-center">
      {items.map((it, i) => (
        <span key={i} className="flex items-center font-mono text-xs tracking-wide text-[var(--muted)]">
          <span className="px-5 whitespace-nowrap">{it}</span>
          <svg width="7" height="7" viewBox="0 0 8 8" className="text-[var(--accent)]">
            <rect width="8" height="8" transform="rotate(45 4 4)" fill="currentColor" />
          </svg>
        </span>
      ))}
    </div>
  );
  return (
    <div className="ticker-mask relative overflow-hidden border-y border-[var(--border)] bg-[var(--bg2)] py-3">
      <div className="ticker-track">
        {row(false)}
        {row(true)}
      </div>
    </div>
  );
}

/* ── Botón copiar ────────────────────────────────────────────────── */
export function CopyBtn({ text, label = "Copiar" }: { text: string; label?: string }) {
  const [ok, setOk] = useState(false);
  const copy = async () => {
    try {
      await navigator.clipboard.writeText(text);
    } catch {
      const ta = document.createElement("textarea");
      ta.value = text;
      document.body.appendChild(ta);
      ta.select();
      document.execCommand("copy");
      ta.remove();
    }
    setOk(true);
    window.setTimeout(() => setOk(false), 1600);
  };
  return (
    <button
      onClick={copy}
      className={`group inline-flex items-center gap-2 border px-3 py-1.5 font-mono text-[11px] uppercase tracking-widest transition-all duration-200 ${
        ok
          ? "border-[var(--ok)] text-[var(--ok)]"
          : "border-[var(--border2)] text-[var(--muted)] hover:border-[var(--accent)] hover:text-[var(--fg)]"
      }`}
      style={{ borderRadius: "var(--radius)" }}
      aria-live="polite"
    >
      {ok ? <IconCheck className="w-3.5 h-3.5" /> : <IconCopy className="w-3.5 h-3.5" />}
      {ok ? "Copiado" : label}
    </button>
  );
}

/* ── Iconos SVG propios ──────────────────────────────────────────── */
type IP = { className?: string };
const S = { fill: "none", stroke: "currentColor", strokeWidth: 1.8, strokeLinecap: "round", strokeLinejoin: "round" } as const;

export const IconCheck = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><path d="M2.5 8.5l3.5 3.5 7.5-8" /></svg>
);
export const IconCopy = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><rect x="5" y="5" width="9" height="9" rx="1.5" /><path d="M11 3H3.5A1.5 1.5 0 002 4.5V11" /></svg>
);
export const IconChevron = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><path d="M4 6l4 4 4-4" /></svg>
);
export const IconArrow = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><path d="M2 8h11M9 3.5L13.5 8 9 12.5" /></svg>
);
export const IconStar = ({ className = "w-4 h-4", filled = false }: IP & { filled?: boolean }) => (
  <svg viewBox="0 0 16 16" className={className} {...S} fill={filled ? "currentColor" : "none"}>
    <path d="M8 1.8l1.9 3.9 4.3.6-3.1 3 .7 4.3L8 11.6l-3.8 2 .7-4.3-3.1-3 4.3-.6z" />
  </svg>
);
export const IconMenu = ({ className = "w-5 h-5" }: IP) => (
  <svg viewBox="0 0 20 20" className={className} {...S}><path d="M3 5.5h14M3 10h14M3 14.5h14" /></svg>
);
export const IconX = ({ className = "w-5 h-5" }: IP) => (
  <svg viewBox="0 0 20 20" className={className} {...S}><path d="M4.5 4.5l11 11M15.5 4.5l-11 11" /></svg>
);
export const IconLayers = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><path d="M8 1.8L14.5 5 8 8.2 1.5 5z" /><path d="M1.5 8.4L8 11.6l6.5-3.2" /><path d="M1.5 11.6L8 14.8l6.5-3.2" /></svg>
);
export const IconBolt = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><path d="M9 1.5L3 9h4l-1 5.5L12.5 7h-4z" /></svg>
);
export const IconShield = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><path d="M8 1.5l5.5 2v4.2c0 3.4-2.3 5.6-5.5 6.8-3.2-1.2-5.5-3.4-5.5-6.8V3.5z" /><path d="M5.5 8l2 2 3.5-3.8" /></svg>
);
export const IconKey = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><rect x="1.5" y="4" width="13" height="8" rx="1.5" /><path d="M4.5 10h.01M7.5 10h4" /></svg>
);
export const IconDoc = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><path d="M9.5 1.5H4A1.5 1.5 0 002.5 3v10A1.5 1.5 0 004 14.5h8a1.5 1.5 0 001.5-1.5V5.5z" /><path d="M9.5 1.5v4h4M5.5 9h5M5.5 11.5h5" /></svg>
);
export const IconWp = ({ className = "w-4 h-4" }: IP) => (
  <svg viewBox="0 0 16 16" className={className} {...S}><circle cx="8" cy="8" r="6.3" /><path d="M2.5 5.5h2M8 5.5l-2.3 6L4.3 8M8 5.5l2.4 6-1.2-3.2M11.5 5.5h2" /></svg>
);

/* Logomarca TBMX — tubo + slash */
export const LogoMark = ({ className = "w-8 h-8" }: IP) => (
  <svg viewBox="0 0 32 32" className={className} fill="none">
    <rect x="2.5" y="2.5" width="27" height="27" stroke="currentColor" strokeWidth="2" />
    <path d="M9 9v14M9 9h6M17 23L24 9" stroke="var(--accent)" strokeWidth="2.4" strokeLinecap="square" />
  </svg>
);
