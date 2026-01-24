<style>
    :root {
        --brand-primary: #2563eb;
        --brand-primary-dark: #1e3a8a;
        --brand-accent: #fbbf24;
        --brand-bg: linear-gradient(120deg, #1d4ed8, #1e3a8a 45%, #312e81);
        --brand-glass: rgba(255, 255, 255, 0.08);
    }

    .brand-gradient {
        background-image: var(--brand-bg);
    }

    .brand-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 15px 45px rgba(15, 23, 42, 0.12);
    }

    .brand-button {
        background-image: linear-gradient(135deg, #3b82f6, #6366f1);
        color: #fff;
        border: none;
    }

    .brand-button:hover {
        filter: brightness(1.05);
        transform: translateY(-1px);
    }

    .brand-pill {
        border-radius: 9999px;
        background-color: rgba(255, 255, 255, 0.08);
        color: #fff;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        letter-spacing: 0.08em;
    }

    .brand-link {
        color: #bfdbfe;
        transition: color 0.2s ease;
    }

    .brand-link:hover {
        color: #fff;
    }
</style>
