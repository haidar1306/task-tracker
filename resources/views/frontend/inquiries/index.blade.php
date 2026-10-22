@extends('frontend.layouts.apps')

@section('title', 'My Inquiries')

@push('after-styles')
<style>
    :root {
        --iq-gold: #a9825c; --iq-ink: #2b2621; --iq-bg: #f7f2ea;
        --iq-card: #fffdfa; --iq-line: #e5dccb; --iq-mute: #8a7f6f;
    }
    .iq-page { padding: 70px 0 90px; background: var(--iq-bg); min-height: 70vh; font-family: 'Jost', sans-serif; }
    .iq-wrap { max-width: 900px; margin: 0 auto; }

    .iq-back { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 18px; padding: 9px 18px; border: 1px solid var(--iq-line); border-radius: 30px; background: var(--iq-card); color: var(--iq-ink); font-size: 13px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; text-decoration: none; transition: .2s; }
    .iq-back:hover { background: var(--iq-ink); border-color: var(--iq-ink); color: #fff; text-decoration: none; }
    .iq-back:focus-visible { outline: 2px solid var(--iq-gold); outline-offset: 2px; }

    .iq-head { display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 14px; margin-bottom: 26px; }
    .iq-head h1 { margin: 0; font: 700 32px 'Playfair Display', serif; color: var(--iq-ink); }
    .iq-head p { margin: 4px 0 0; color: var(--iq-mute); font-size: 14px; }
    .iq-new { padding: 11px 22px; border-radius: 8px; background: var(--iq-ink); color: #fff; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; transition: .2s; }
    .iq-new:hover { background: var(--iq-gold); color: #fff; text-decoration: none; }

    /* Stats */
    .iq-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 22px; }
    .iq-stat { background: var(--iq-card); border: 1px solid var(--iq-line); border-radius: 12px; padding: 16px 20px; }
    .iq-stat b { display: block; font: 700 28px 'Playfair Display', serif; color: var(--iq-ink); line-height: 1.1; }
    .iq-stat span { font-size: 13px; color: var(--iq-mute); }

    /* Toolbar */
    .iq-bar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 14px; }
    .iq-tabs { display: flex; gap: 6px; }
    .iq-tabs a { padding: 8px 16px; border-radius: 30px; border: 1px solid var(--iq-line); background: var(--iq-card); color: var(--iq-mute); font-size: 13px; font-weight: 600; text-decoration: none; }
    .iq-tabs a.active { background: var(--iq-ink); border-color: var(--iq-ink); color: #fff; }
    .iq-search { position: relative; }
    .iq-search input { width: 240px; max-width: 100%; padding: 9px 14px 9px 36px; border: 1px solid var(--iq-line); border-radius: 30px; background: var(--iq-card); font: 14px 'Jost', sans-serif; color: var(--iq-ink); }
    .iq-search input:focus { outline: 2px solid var(--iq-gold); outline-offset: 1px; }
    .iq-search i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--iq-mute); font-size: 13px; }

    /* List */
    .iq-list { background: var(--iq-card); border: 1px solid var(--iq-line); border-radius: 14px; overflow: hidden; }
    .iq-row { display: flex; align-items: center; gap: 16px; width: 100%; padding: 18px 22px; border: 0; border-bottom: 1px solid #eee2d0; background: transparent; text-align: left; cursor: pointer; transition: background .15s; }
    .iq-row:last-child { border-bottom: 0; }
    .iq-row:hover, .iq-row.is-open { background: #fbf7ef; }
    .iq-row:focus-visible { outline: 2px solid var(--iq-gold); outline-offset: -2px; }
    .iq-dot { flex: 0 0 9px; width: 9px; height: 9px; border-radius: 50%; background: transparent; }
    .iq-row.is-unread .iq-dot { background: var(--iq-gold); box-shadow: 0 0 0 4px rgba(169,130,92,.18); }
    .iq-main { flex: 1; min-width: 0; }
    .iq-subject { display: block; color: var(--iq-ink); font-size: 16px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .iq-row.is-unread .iq-subject { font-weight: 700; }
    .iq-snippet { display: block; margin-top: 3px; color: var(--iq-mute); font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .iq-side { text-align: right; flex: 0 0 auto; }
    .iq-date { display: block; margin-top: 6px; color: #a39886; font-size: 12px; }

    .iq-badge { display: inline-block; padding: 4px 12px; border-radius: 30px; font-size: 11px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; }
    .iq-badge.replied { background: #eef7ee; color: #2e6b34; border: 1px solid #b9dcb9; }
    .iq-badge.pending { background: #fdf6e7; color: #8f6a1f; border: 1px solid #ecd9a8; }

    .iq-empty { padding: 60px 20px; text-align: center; color: var(--iq-mute); }
    .iq-empty h3 { margin: 0 0 6px; font: 700 20px 'Playfair Display', serif; color: var(--iq-ink); }
    .iq-pager { margin-top: 20px; display: flex; justify-content: center; }

    /* Drawer */
    .iq-overlay { position: fixed; inset: 0; background: rgba(43,38,33,.45); opacity: 0; visibility: hidden; transition: .25s; z-index: 1040; }
    .iq-drawer { position: fixed; top: 0; right: 0; bottom: 0; width: 480px; max-width: 100%; background: var(--iq-card); border-left: 1px solid var(--iq-line); box-shadow: -20px 0 50px rgba(43,38,33,.15); transform: translateX(100%); transition: transform .3s cubic-bezier(.2,.7,.2,1); z-index: 1050; display: flex; flex-direction: column; }
    body.iq-open .iq-overlay { opacity: 1; visibility: visible; }
    body.iq-open .iq-drawer { transform: none; }
    body.iq-open { overflow: hidden; }
    .iq-drawer-head { display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1px solid #eee2d0; }
    .iq-drawer-head b { font: 700 18px 'Playfair Display', serif; color: var(--iq-ink); }
    .iq-close { width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--iq-line); background: transparent; color: var(--iq-ink); cursor: pointer; }
    .iq-close:hover { background: var(--iq-ink); color: #fff; }
    .iq-drawer-body { flex: 1; overflow-y: auto; padding: 24px; }

    .iq-d-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .iq-d-id { color: var(--iq-gold); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
    .iq-d-subject { margin: 0 0 20px; font: 700 22px/1.3 'Playfair Display', serif; color: var(--iq-ink); word-break: break-word; }
    .iq-d-label { display: block; margin-bottom: 8px; color: var(--iq-mute); font-size: 12px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; }
    .iq-d-label i { color: var(--iq-gold); margin-right: 4px; }
    .iq-d-block { margin-bottom: 20px; }
    .iq-d-msg { padding: 14px 16px; background: var(--iq-bg); border: 1px solid var(--iq-line); border-radius: 10px; color: var(--iq-ink); font-size: 15px; line-height: 1.7; word-break: break-word; }
    .iq-d-reply { padding: 16px 18px; background: #fbf7ef; border: 1px solid var(--iq-line); border-left: 4px solid var(--iq-gold); border-radius: 10px; }
    .iq-d-reply p { margin: 0; color: var(--iq-ink); font-size: 15px; line-height: 1.7; word-break: break-word; }
    .iq-d-actions { margin-top: 26px; padding-top: 20px; border-top: 1px solid #eee2d0; }
    .iq-btn-outline { display: inline-flex; gap: 8px; align-items: center; padding: 11px 22px; border: 1px solid var(--iq-gold); border-radius: 8px; color: var(--iq-gold); font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; transition: .2s; }
    .iq-btn-outline:hover { background: var(--iq-gold); color: #fff; text-decoration: none; }

    /* Timeline */
    .iq-timeline { list-style: none; margin: 0 0 24px; padding: 0 0 0 22px; border-left: 2px solid var(--iq-line); }
    .iq-timeline li { position: relative; padding-bottom: 14px; }
    .iq-timeline li:last-child { padding-bottom: 0; }
    .iq-timeline li::before { content: ""; position: absolute; left: -29px; top: 3px; width: 12px; height: 12px; border-radius: 50%; background: var(--iq-card); border: 2px solid var(--iq-line); }
    .iq-timeline li.done::before { background: var(--iq-gold); border-color: var(--iq-gold); }
    .iq-timeline strong { display: block; font-size: 14px; color: var(--iq-ink); }
    .iq-timeline span { font-size: 12px; color: #a39886; }

    /* Skeleton */
    .iq-skel div { height: 14px; margin-bottom: 14px; border-radius: 6px; background: linear-gradient(90deg, #efe7d8 25%, #f8f3ea 50%, #efe7d8 75%); background-size: 200% 100%; animation: iqShine 1.2s infinite; }
    @keyframes iqShine { to { background-position: -200% 0; } }

    @media (max-width: 575px) {
        .iq-page { padding: 30px 0 60px; }
        .iq-stats { gap: 8px; }
        .iq-stat { padding: 12px; }
        .iq-stat b { font-size: 22px; }
        .iq-row { padding: 14px 16px; }
        .iq-side .iq-date { display: none; }
        .iq-search input, .iq-search { width: 100%; }
    }
    @media (prefers-reduced-motion: reduce) {
        .iq-drawer, .iq-overlay, .iq-skel div { transition: none; animation: none; }
    }
</style>
@endpush

@section('content')
<section class="iq-page">
    <div class="container">
        <div class="iq-wrap">

            @php
                // Pichla page jaha se aaye; agar wo isi page ka filter/search tha to home par bhejo
                $prev    = url()->previous();
                $backUrl = \Illuminate\Support\Str::contains($prev, '/my-inquiries') ? url('/') : $prev;
            @endphp
            <a href="{{ $backUrl }}" class="iq-back"><i class="fas fa-arrow-left"></i> Back</a>

            <div class="iq-head">
                <div>
                    <h1>My Inquiries</h1>
                    <p>
                        @if($stats['unread'] > 0)
                            <span id="iqUnread">{{ $stats['unread'] }}</span> new {{ Str::plural('reply', $stats['unread']) }} from the hotel
                        @else
                            Track your messages and the hotel's replies
                        @endif
                    </p>
                </div>
                <a href="{{ route('frontend.contact') }}" class="iq-new">New inquiry</a>
            </div>

            <div class="iq-stats">
                <div class="iq-stat"><b>{{ $stats['all'] }}</b><span>Total</span></div>
                <div class="iq-stat"><b>{{ $stats['pending'] }}</b><span>Pending</span></div>
                <div class="iq-stat"><b>{{ $stats['replied'] }}</b><span>Replied</span></div>
            </div>

            <div class="iq-bar">
                <div class="iq-tabs" id="iqTabs">
                    @foreach(['all' => 'All', 'pending' => 'Pending', 'replied' => 'Replied'] as $key => $label)
                        <a href="{{ route('frontend.frontend.inquiries.index', array_filter(['status' => $key === 'all' ? null : $key, 'q' => $search])) }}"
                           class="{{ $status === $key ? 'active' : '' }}">{{ $label }}</a>
                    @endforeach
                </div>
                <form class="iq-search" method="GET" action="{{ route('frontend.frontend.inquiries.index') }}">
                    @if($status !== 'all')<input type="hidden" name="status" value="{{ $status }}">@endif
                    <i class="fas fa-search"></i>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Search subject or message" aria-label="Search inquiries">
                </form>
            </div>

            <div id="iqListWrap">
            <div class="iq-list">
                @forelse($inquiries as $inq)
                    <button type="button"
                            class="iq-row {{ $inq->is_unread_reply ? 'is-unread' : '' }}"
                            data-id="{{ $inq->id }}">
                        <span class="iq-dot" aria-hidden="true"></span>
                        <span class="iq-main">
                            <span class="iq-subject">{{ $inq->subject }}</span>
                            <span class="iq-snippet">{{ Str::limit($inq->is_replied ? $inq->reply : $inq->message, 90) }}</span>
                        </span>
                        <span class="iq-side">
                            <span class="iq-badge {{ $inq->is_replied ? 'replied' : 'pending' }}">{{ $inq->is_replied ? 'Replied' : 'Pending' }}</span>
                            <span class="iq-date">{{ $inq->created_at->format('d M Y') }}</span>
                        </span>
                    </button>
                @empty
                    <div class="iq-empty">
                        <h3>{{ $search !== '' || $status !== 'all' ? 'No inquiries match' : 'No inquiries yet' }}</h3>
                        <p>{{ $search !== '' || $status !== 'all' ? 'Try a different filter or search term.' : 'Send us a message and it will show up here.' }}</p>
                    </div>
                @endforelse
            </div>

            @if($inquiries->hasPages())
                <div class="iq-pager">{{ $inquiries->links() }}</div>
            @endif
            </div>

        </div>
    </div>
</section>

{{-- Drawer --}}
<div class="iq-overlay" id="iqOverlay"></div>
<aside class="iq-drawer" id="iqDrawer" role="dialog" aria-modal="true" aria-labelledby="iqDrawerTitle">
    <div class="iq-drawer-head">
        <b id="iqDrawerTitle">Inquiry details</b>
        <button type="button" class="iq-close" id="iqClose" aria-label="Close"><i class="fas fa-times"></i></button>
    </div>
    <div class="iq-drawer-body" id="iqBody"></div>
</aside>
@endsection

@push('after-scripts')
<script>
(function () {
    // URL current page ke path se banta hai (APP_URL / host se independent)
    const listPath = location.pathname.replace(/\/+$/, '');
    const body = document.body;
    const panel = document.getElementById('iqBody');
    const closeBtn = document.getElementById('iqClose');
    const skeleton = '<div class="iq-skel"><div style="width:35%"></div><div style="width:80%;height:22px"></div><div style="width:55%"></div><div style="height:70px"></div><div style="height:90px"></div></div>';
    let lastRow = null;

    function setParam(id) {
        const u = new URL(location.href);
        id ? u.searchParams.set('inquiry', id) : u.searchParams.delete('inquiry');
        history.pushState({ id: id }, '', u);
    }

    function openInquiry(id, push) {
        document.querySelectorAll('.iq-row.is-open').forEach(r => r.classList.remove('is-open'));
        const row = document.querySelector('.iq-row[data-id="' + id + '"]');
        if (row) { row.classList.add('is-open'); lastRow = row; }

        panel.innerHTML = skeleton;
        body.classList.add('iq-open');
        closeBtn.focus();
        if (push) setParam(id);

        fetch(listPath + '/' + encodeURIComponent(id) + '/detail', {
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(d => {
            panel.innerHTML = d.html;
            if (row) row.classList.remove('is-unread');
            const badge = document.getElementById('iqUnread');
            if (badge) badge.textContent = d.unread;
        })
        .catch(err => {
            console.error('Inquiry load failed:', err);
            panel.innerHTML = '<div class="iq-empty"><h3>Could not load inquiry</h3><p>Please close this panel and try again.</p><p style="font-size:12px;opacity:.7">' + (err && err.message ? err.message : '') + '</p></div>';
        });
    }

    function closeInquiry(push) {
        body.classList.remove('iq-open');
        document.querySelectorAll('.iq-row.is-open').forEach(r => r.classList.remove('is-open'));
        if (push) setParam(null);
        if (lastRow && document.body.contains(lastRow)) lastRow.focus();
    }

    document.addEventListener('click', e => {
        const row = e.target.closest('.iq-row');
        if (row) openInquiry(row.dataset.id, true);
    });
    document.getElementById('iqOverlay').addEventListener('click', () => closeInquiry(true));
    closeBtn.addEventListener('click', () => closeInquiry(true));
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && body.classList.contains('iq-open')) closeInquiry(true); });

    window.addEventListener('popstate', () => {
        const id = new URL(location.href).searchParams.get('inquiry');
        id ? openInquiry(id, false) : closeInquiry(false);
    });

    // Live search: type karte hi results, box khali karte hi original list
    const searchForm  = document.querySelector('.iq-search');
    const searchInput = searchForm.querySelector('input[name="q"]');
    let searchTimer = null, searchCtrl = null;

    function runSearch() {
        const params = new URLSearchParams(location.search);
        const q = searchInput.value.trim();
        q ? params.set('q', q) : params.delete('q');
        params.delete('page');
        params.delete('inquiry');
        const qs  = params.toString();
        const url = location.pathname + (qs ? '?' + qs : '');

        if (searchCtrl) searchCtrl.abort();
        searchCtrl = new AbortController();
        const wrap = document.getElementById('iqListWrap');
        wrap.style.opacity = '.5';

        fetch(url, {
            signal: searchCtrl.signal,
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.text(); })
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const newWrap = doc.getElementById('iqListWrap');
            const newTabs = doc.getElementById('iqTabs');
            if (!newWrap) throw new Error('Bad response');
            wrap.innerHTML = newWrap.innerHTML;
            if (newTabs) document.getElementById('iqTabs').innerHTML = newTabs.innerHTML;
            history.replaceState(history.state, '', url);
            wrap.style.opacity = '';
        })
        .catch(err => {
            if (err.name !== 'AbortError') { wrap.style.opacity = ''; console.error('Search failed:', err); }
        });
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(runSearch, 300);
    });
    searchForm.addEventListener('submit', e => {
        e.preventDefault();
        clearTimeout(searchTimer);
        runSearch();
    });

    // Direct link / notification: ?inquiry=8
    const initial = new URL(location.href).searchParams.get('inquiry');
    if (initial) openInquiry(initial, false);
})();
</script>
@endpush