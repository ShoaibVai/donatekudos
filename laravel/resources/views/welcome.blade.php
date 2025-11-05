@extends('layouts.app')

@section('body-class', 'bg-slate-950 text-slate-100')

@section('content')
<div class="relative min-h-screen overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 via-purple-500/10 to-slate-950"></div>
        <div class="absolute -left-32 top-24 h-72 w-72 rounded-full bg-amber-500/20 blur-3xl"></div>
        <div class="absolute -right-20 bottom-10 h-64 w-64 rounded-full bg-purple-500/20 blur-3xl"></div>
    </div>

    <header class="relative z-10">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-semibold tracking-tight">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-amber-400/20 text-amber-300">DK</span>
                <span>Donate<span class="text-amber-400">Kudos</span></span>
            </a>
            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-200 lg:flex">
                <a href="#features" class="transition hover:text-white">Features</a>
                <a href="#how-it-works" class="transition hover:text-white">How it works</a>
                <a href="#community" class="transition hover:text-white">Community</a>
            </nav>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-medium text-slate-200 transition hover:text-white">Log in</a>
                    <a href="{{ route('signup') }}" class="rounded-full bg-amber-400 px-5 py-2 text-sm font-semibold text-slate-950 shadow-lg shadow-amber-500/30 transition hover:bg-amber-300">Create profile</a>
                @else
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-white/10 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-purple-500/20 transition hover:bg-white/20">Open dashboard</a>
                @endguest
            </div>
        </div>
    </header>

    <main class="relative z-10 mx-auto grid max-w-6xl gap-16 px-6 pb-24 pt-10 lg:grid-cols-2 lg:items-center lg:pt-20">
        <section class="space-y-8">
            <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs uppercase tracking-wide text-amber-200/90">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                Built for mission-driven creators
            </p>
            <h1 class="text-4xl font-semibold leading-tight text-white sm:text-5xl lg:text-6xl">
                Turn every donation into a story worth sharing.
            </h1>
            <p class="max-w-xl text-base leading-relaxed text-slate-200/80">
                DonateKudos makes it simple to launch a beautiful supporter profile, showcase impact updates, and give donors transparency through secure wallet links and galleries.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                @guest
                    <a href="{{ route('signup') }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-amber-500/30 transition hover:bg-amber-300">Start in minutes</a>
                    <a href="{{ route('login') }}" class="rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">I already have an account</a>
                @else
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-amber-500/30 transition hover:bg-amber-300">Go to dashboard</a>
                    <a href="#features" class="rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Explore features</a>
                @endguest
            </div>
            <dl class="grid max-w-2xl grid-cols-1 gap-6 text-left sm:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-amber-200">Profiles launched</dt>
                    <dd class="mt-2 text-2xl font-semibold text-white">1.2k+</dd>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-amber-200">Funds tracked</dt>
                    <dd class="mt-2 text-2xl font-semibold text-white">$2.4M</dd>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-amber-200">Supporter satisfaction</dt>
                    <dd class="mt-2 text-2xl font-semibold text-white">98%</dd>
                </div>
            </dl>
        </section>

        <section class="relative">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-white">Live profile preview</p>
                        <p class="text-xs text-slate-200/70">Personalized, mobile-first, and donation ready.</p>
                    </div>
                    <span class="rounded-full bg-emerald-400/20 px-3 py-1 text-xs font-semibold text-emerald-200">Real-time</span>
                </div>
                <div class="mt-8 space-y-4">
                    <div class="rounded-2xl bg-slate-900/60 p-4">
                        <p class="text-sm font-semibold text-white">Impact gallery</p>
                        <p class="mt-1 text-xs text-slate-200/70">Upload photos, stories, and quick updates your supporters can revisit anytime.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-900/60 p-4">
                        <p class="text-sm font-semibold text-white">Wallet transparency</p>
                        <p class="mt-1 text-xs text-slate-200/70">Secure QR codes let donors verify blockchain contributions without leaving your page.</p>
                    </div>
                    <div class="rounded-2xl bg-slate-900/60 p-4">
                        <p class="text-sm font-semibold text-white">Smart profile link</p>
                        <p class="mt-1 text-xs text-slate-200/70">Share a single link to highlight all your social channels and donation options.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <section id="features" class="relative z-10 mx-auto max-w-6xl px-6 pb-24">
        <h2 class="text-center text-3xl font-semibold text-white sm:text-4xl">Why teams choose DonateKudos</h2>
        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <article class="rounded-3xl border border-white/10 bg-white/5 p-6 text-left">
                <h3 class="text-lg font-semibold text-white">Unified donor hub</h3>
                <p class="mt-2 text-sm text-slate-200/80">Manage profiles, galleries, and wallet QR codes from one intuitive dashboard.</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-white/5 p-6 text-left">
                <h3 class="text-lg font-semibold text-white">Security-first authentication</h3>
                <p class="mt-2 text-sm text-slate-200/80">Two-factor flows keep every login protected while keeping onboarding simple.</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-white/5 p-6 text-left">
                <h3 class="text-lg font-semibold text-white">Shareable storytelling</h3>
                <p class="mt-2 text-sm text-slate-200/80">Highlight impact moments with galleries, bios, and direct links to social updates.</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-white/5 p-6 text-left">
                <h3 class="text-lg font-semibold text-white">Analytics ready</h3>
                <p class="mt-2 text-sm text-slate-200/80">Export supporter data and deleted user reports to keep compliance effortless.</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-white/5 p-6 text-left">
                <h3 class="text-lg font-semibold text-white">Team friendly</h3>
                <p class="mt-2 text-sm text-slate-200/80">Admin tools help moderators review flagged content and manage community safety.</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-white/5 p-6 text-left">
                <h3 class="text-lg font-semibold text-white">Fast to deploy</h3>
                <p class="mt-2 text-sm text-slate-200/80">Launch a polished supporter experience in under five minutes—no engineers needed.</p>
            </article>
        </div>
    </section>

    <section id="how-it-works" class="relative z-10 mx-auto max-w-6xl px-6 pb-24">
        <div class="grid gap-10 rounded-3xl border border-white/10 bg-white/5 p-10 lg:grid-cols-2">
            <div>
                <h2 class="text-3xl font-semibold text-white sm:text-4xl">Launch, update, and celebrate—in one flow.</h2>
                <p class="mt-4 text-sm leading-relaxed text-slate-200/80">Our guided setup walks you through profile creation, gallery uploads, and wallet verification so donors understand where their impact lands.</p>
            </div>
            <ol class="space-y-4 text-left">
                <li class="flex items-start gap-4 rounded-2xl bg-slate-900/60 p-4">
                    <span class="mt-1 inline-flex h-7 w-7 items-center justify-center rounded-full bg-amber-400/30 text-sm font-semibold text-amber-200">1</span>
                    <div>
                        <p class="text-sm font-semibold text-white">Sign up & secure your account</p>
                        <p class="text-xs text-slate-200/70">Enable TOTP during onboarding so every team member signs in safely.</p>
                    </div>
                </li>
                <li class="flex items-start gap-4 rounded-2xl bg-slate-900/60 p-4">
                    <span class="mt-1 inline-flex h-7 w-7 items-center justify-center rounded-full bg-amber-400/30 text-sm font-semibold text-amber-200">2</span>
                    <div>
                        <p class="text-sm font-semibold text-white">Customize your profile</p>
                        <p class="text-xs text-slate-200/70">Add bios, wallet QR codes, and gallery items that highlight your mission.</p>
                    </div>
                </li>
                <li class="flex items-start gap-4 rounded-2xl bg-slate-900/60 p-4">
                    <span class="mt-1 inline-flex h-7 w-7 items-center justify-center rounded-full bg-amber-400/30 text-sm font-semibold text-amber-200">3</span>
                    <div>
                        <p class="text-sm font-semibold text-white">Share with supporters</p>
                        <p class="text-xs text-slate-200/70">Use your smart profile link across social channels and watch donations grow.</p>
                    </div>
                </li>
            </ol>
        </div>
    </section>

    <section id="community" class="relative z-10 mx-auto max-w-6xl px-6 pb-24">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-10 text-center">
            <h2 class="text-3xl font-semibold text-white sm:text-4xl">Ready to welcome your next supporter?</h2>
            <p class="mt-4 text-sm text-slate-200/80">Join community teams, nonprofits, and solo creators who rely on DonateKudos to stay accountable and inspiring.</p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                @guest
                    <a href="{{ route('signup') }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-amber-500/30 transition hover:bg-amber-300">Create my profile</a>
                    <a href="{{ route('login') }}" class="rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Sign in</a>
                @else
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-amber-500/30 transition hover:bg-amber-300">Open dashboard</a>
                @endguest
            </div>
        </div>
    </section>

    <footer class="relative z-10 border-t border-white/10 bg-slate-950/60 py-8">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-6 text-xs text-slate-400 sm:flex-row">
            <p>© {{ now()->year }} DonateKudos. All rights reserved.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="mailto:support@donatekudos.test" class="transition hover:text-white">Support</a>
                <a href="#features" class="transition hover:text-white">Product</a>
                <a href="#community" class="transition hover:text-white">Community</a>
            </div>
        </div>
    </footer>
</div>
@endsection
