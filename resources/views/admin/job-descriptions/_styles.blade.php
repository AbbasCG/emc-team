{{-- Job Description module — shared styles --}}
<style>
    /* ── Page shells ── */
    .jd-index-page {
        max-width: 1500px;
        margin: 0 auto;
        width: 100%;
        animation: jdFadeIn 0.35s ease;
    }
    .jd-show-page {
        max-width: 1120px;
        margin: 0 auto;
        width: 100%;
        animation: jdFadeIn 0.35s ease;
    }

    @keyframes jdFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Toolbar (index) ── */
    .jd-toolbar {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 8px 12px;
        margin-bottom: 16px;
        box-shadow: 0 1px 3px rgba(34,51,74,0.04);
    }
    .jd-toolbar-search {
        flex: 1 1 200px;
        min-width: 0;
        position: relative;
    }
    .jd-toolbar-search svg {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #94A3B8;
    }
    .jd-toolbar-search input {
        width: 100%;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 10px 36px 10px 12px;
        font-size: 0.84rem;
        font-family: inherit;
        color: #0F172A;
        background: #F8FAFC;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .jd-toolbar-search input:focus {
        border-color: #2691C2;
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(38,145,194,0.12);
    }
    .jd-toolbar-select {
        flex: 0 1 160px;
        min-width: 140px;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 0.84rem;
        font-family: inherit;
        color: #0F172A;
        background: #FFFFFF;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .jd-toolbar-select:focus { border-color: #2691C2; }
    .jd-toolbar-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 0.84rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        border: none;
        white-space: nowrap;
        transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    .jd-toolbar-btn-filter {
        background: #F8FAFC;
        color: #22334A;
        border: 1px solid #E2E8F0;
    }
    .jd-toolbar-btn-filter:hover { background: #F1F5F9; }
    .jd-toolbar-btn-create {
        background: #EC943C;
        color: #FFFFFF;
        margin-inline-start: auto;
    }
    .jd-toolbar-btn-create:hover {
        background: #d4832a;
        box-shadow: 0 4px 12px rgba(236,148,60,0.35);
        transform: translateY(-1px);
    }

    @media (max-width: 767px) {
        .jd-toolbar { padding: 8px; }
        .jd-toolbar-select { flex: 1 1 calc(50% - 4px); min-width: 0; }
        .jd-toolbar-btn-create { width: 100%; margin-inline-start: 0; order: -1; }
    }

    /* ── Card grid (index) ── */
    .jd-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    @media (min-width: 768px)  { .jd-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1280px) { .jd-grid { grid-template-columns: repeat(3, 1fr); } }

    .jd-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        overflow: hidden;
        min-width: 0;
        box-shadow: 0 1px 3px rgba(34,51,74,0.05), 0 1px 2px rgba(34,51,74,0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .jd-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(34,51,74,0.1), 0 4px 8px rgba(34,51,74,0.04);
        border-color: #CBD5E1;
    }

    .jd-card-top {
        padding: 24px 24px 16px;
        text-align: center;
    }
    .jd-card-icon {
        width: 56px;
        height: 56px;
        margin: 0 0 25px;
        border-radius: 16px;
        background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
        border: 1px solid #BFDBFE;
        color: #2691C2;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
    }
    .jd-card:hover .jd-card-icon { transform: scale(1.04); }
    .jd-card-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #22334A;
        line-height: 1.4;
        margin: 0 0 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* -webkit-box-orient: vertical; */
        overflow: hidden;
    }
    .jd-card-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        /* justify-content: center; */
    }
    .jd-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 0.68rem;
        font-weight: 700;
        line-height: 1;
    }
    .jd-badge-dept {
        background: #F8FAFC;
        color: #475569;
        border: 1px solid #E2E8F0;
    }
    .jd-badge-active {
        background: #F0FDF4;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }
    .jd-badge-inactive {
        background: #F1F5F9;
        color: #64748B;
        border: 1px solid #E2E8F0;
    }

    .jd-card-mid {
        padding: 0 24px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }
    .jd-card-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 0.76rem;
        line-height: 1.45;
    }
    .jd-card-row-icon {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: #F8FAFC;
        border: 1px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #94A3B8;
    }
    .jd-card-row-label {
        color: #94A3B8;
        flex-shrink: 0;
        min-width: 64px;
        font-weight: 600;
    }
    .jd-card-row-value {
        color: #475569;
        font-weight: 600;
        word-break: break-word;
    }

    .jd-card-stats {
        display: flex;
        gap: 8px;
        padding: 0 24px 16px;
    }
    .jd-stat-pill {
        flex: 1;
        background: #F8FAFC;
        border: 1px solid #F1F5F9;
        border-radius: 10px;
        padding: 8px 10px;
        text-align: center;
    }
    .jd-stat-pill-value {
        font-size: 0.82rem;
        font-weight: 800;
        color: #22334A;
        line-height: 1.2;
    }
    .jd-stat-pill-label {
        font-size: 0.62rem;
        font-weight: 600;
        color: #94A3B8;
        margin-top: 2px;
    }

    .jd-card-foot {
        padding: 12px 16px;
        border-top: 1px solid #F1F5F9;
        background: #FAFBFC;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* ── Empty state ── */
    .jd-empty {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 20px;
        padding: 64px 32px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(34,51,74,0.04);
    }
    .jd-empty-illustration {
        width: 88px;
        height: 88px;
        margin: 0 auto 24px;
        border-radius: 24px;
        background: linear-gradient(135deg, #F8FAFC 0%, #EFF6FF 100%);
        border: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2691C2;
    }
    .jd-empty h2 {
        font-size: 1.1rem;
        font-weight: 900;
        color: #22334A;
        margin: 0 0 8px;
    }
    .jd-empty p {
        font-size: 0.84rem;
        color: #64748B;
        line-height: 1.65;
        max-width: 360px;
        margin: 0 auto 24px;
    }
    .jd-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #EC943C;
        color: #FFFFFF;
        border: none;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 700;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    .jd-empty-btn:hover {
        background: #d4832a;
        box-shadow: 0 6px 20px rgba(236,148,60,0.35);
        transform: translateY(-1px);
    }

    /* ── Show page sections ── */
    .jd-section {
        margin-bottom: 16px;
    }
    .jd-section-head {
        font-size: 0.72rem;
        font-weight: 800;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        margin: 0 0 8px;
        padding-right: 4px;
    }

    .jd-hero {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 24px;
        padding: 0;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(34,51,74,0.05), 0 1px 2px rgba(34,51,74,0.03);
        overflow: hidden;
    }

    /* Volunteer identity — top of hero */
    .jd-vol-identity {
        padding: 24px 24px 20px;
        background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%);
    }
    .jd-vol-identity-row {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .jd-vol-identity-avatar {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #2691C2;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .jd-vol-identity-body {
        flex: 1;
        min-width: 0;
    }
    .jd-vol-identity-eyebrow {
        font-size: 0.68rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 4px;
    }
    .jd-vol-identity-name {
        font-size: 1.5rem;
        font-weight: 900;
        color: #22334A;
        margin: 0 0 8px;
        line-height: 1.25;
    }
    .jd-vol-identity-name a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .jd-vol-identity-name a:hover { color: #2691C2; }
    .jd-vol-identity-contact {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-bottom: 10px;
    }
    .jd-vol-identity-contact span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: #64748B;
        font-weight: 500;
    }
    .jd-vol-identity-contact svg { flex-shrink: 0; color: #94A3B8; }
    .jd-vol-identity-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }
    .jd-vol-identity-view {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        background: #22334A;
        color: #FFFFFF;
        border-radius: 8px;
        font-size: 0.72rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s, transform 0.2s;
        flex-shrink: 0;
        align-self: flex-start;
    }
    .jd-vol-identity-view:hover {
        background: #1a2d42;
        transform: translateY(-1px);
    }
    .jd-vol-identity-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #E2E8F0;
    }
    .jd-vol-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 100px;
        font-size: 0.72rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        transition: border-color 0.2s, background 0.2s;
    }
    .jd-vol-chip:hover {
        border-color: #2691C2;
        background: #F8FAFC;
        color: #22334A;
    }
    .jd-vol-chip-count {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 100px;
        font-size: 0.68rem;
        font-weight: 700;
        color: #2691C2;
    }
    .jd-vol-identity-empty {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 4px 0;
    }
    .jd-vol-identity-empty-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #F8FAFC;
        border: 1px dashed #CBD5E1;
        color: #94A3B8;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .jd-vol-identity-empty-text {
        font-size: 0.88rem;
        font-weight: 700;
        color: #64748B;
        margin: 0;
        line-height: 1.5;
    }

    .jd-hero-divider {
        height: 1px;
        background: #E2E8F0;
        margin: 0;
    }

    .jd-job-title-block {
        padding: 20px 24px 16px;
    }
    .jd-job-title-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 6px;
    }
    .jd-hero-title {
        font-size: 1.15rem;
        font-weight: 900;
        color: #22334A;
        margin: 0 0 4px;
        line-height: 1.35;
    }
    .jd-hero-sub {
        font-size: 0.78rem;
        color: #64748B;
        margin: 0;
    }
    .jd-hero-supervisor {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #475569;
    }
    .jd-hero-supervisor svg { color: #94A3B8; flex-shrink: 0; }

    .jd-hero-meta-wrap {
        padding: 16px 24px 24px;
    }
    .jd-hero-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 16px;
    }
    @media (min-width: 768px) {
        .jd-hero-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 767px) {
        .jd-vol-identity { padding: 20px 16px 16px; }
        .jd-vol-identity-name { font-size: 1.25rem; }
        .jd-vol-identity-row { flex-wrap: wrap; }
        .jd-vol-identity-view { width: 100%; justify-content: center; }
        .jd-job-title-block { padding: 16px; }
        .jd-hero-meta-wrap { padding: 16px; }
        .jd-hero-grid { grid-template-columns: 1fr; }
    }
    .jd-hero-item-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 2px;
    }
    .jd-hero-item-value {
        font-size: 0.82rem;
        font-weight: 700;
        color: #22334A;
        line-height: 1.4;
    }
    .jd-hero-item-value a {
        color: #2691C2;
        text-decoration: none;
    }
    .jd-hero-item-value a:hover { text-decoration: underline; }

    .jd-block {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 20px 24px;
        box-shadow: 0 1px 3px rgba(34,51,74,0.04);
    }
    .jd-block-text {
        font-size: 0.86rem;
        color: #475569;
        line-height: 1.75;
        margin: 0;
    }

    /* Checklist tasks */
    .jd-task-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .jd-task-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 16px;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .jd-task-item:hover {
        transform: translateX(-2px);
        box-shadow: 0 2px 8px rgba(22,163,74,0.08);
    }
    .jd-task-check {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #16A34A;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .jd-task-text {
        font-size: 0.82rem;
        color: #166534;
        font-weight: 600;
        line-height: 1.55;
        margin: 0;
    }

    /* Qualifications grid */
    .jd-qual-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }
    @media (min-width: 768px) {
        .jd-qual-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .jd-qual-item {
        padding: 12px 16px;
        background: #F8FAFC;
        border: 1px solid #F1F5F9;
        border-radius: 12px;
    }
    .jd-qual-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }
    .jd-qual-value {
        font-size: 0.82rem;
        font-weight: 600;
        color: #22334A;
        line-height: 1.45;
    }

    /* Skill chips */
    .jd-skills-group { margin-bottom: 16px; }
    .jd-skills-group:last-child { margin-bottom: 0; }
    .jd-skills-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #64748B;
        margin-bottom: 8px;
    }
    .jd-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .jd-chip {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .jd-chip:hover {
        transform: scale(1.03);
        box-shadow: 0 2px 6px rgba(38,145,194,0.15);
    }
    .jd-chip-soft {
        background: #FFF7ED;
        color: #C2410C;
        border-color: #FED7AA;
    }

    /* Volunteer profile cards */
    .jd-vol-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    @media (min-width: 768px) {
        .jd-vol-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .jd-vol-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .jd-vol-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(34,51,74,0.08);
    }
    .jd-vol-card-head {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .jd-vol-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #2691C2;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .jd-vol-name {
        font-size: 0.88rem;
        font-weight: 800;
        color: #22334A;
        margin: 0 0 2px;
    }
    .jd-vol-role {
        font-size: 0.7rem;
        font-weight: 600;
        color: #EC943C;
    }
    .jd-vol-rows {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .jd-vol-row {
        display: flex;
        gap: 8px;
        font-size: 0.74rem;
    }
    .jd-vol-row-label { color: #94A3B8; min-width: 56px; flex-shrink: 0; }
    .jd-vol-row-value { color: #475569; font-weight: 600; word-break: break-all; }
    .jd-vol-view {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 14px;
        background: #22334A;
        color: #FFFFFF;
        border-radius: 10px;
        font-size: 0.76rem;
        font-weight: 700;
        text-decoration: none;
        align-self: flex-start;
        transition: background 0.2s, transform 0.2s;
    }
    .jd-vol-view:hover {
        background: #1a2d42;
        transform: translateY(-1px);
    }

    .jd-pagination {
        margin-top: 16px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }

    @media (prefers-reduced-motion: reduce) {
        .jd-card, .jd-card-icon, .jd-task-item, .jd-chip, .jd-vol-card, .jd-toolbar-btn-create, .jd-empty-btn {
            transition: none !important;
        }
        .jd-index-page, .jd-show-page { animation: none; }
    }
</style>
