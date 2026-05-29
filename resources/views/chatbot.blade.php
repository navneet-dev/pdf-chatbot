<x-layouts.app>
    <div class="mx-auto w-full max-w-6xl px-4 py-10 md:py-14">
        <div class="glass-panel rounded-2xl p-6 md:p-8">
            {{-- <p class="text-xs uppercase tracking-[0.22em] text-cyan-300 hidden">Gemini 2.5 Flash</p> --}}
            <h1 class="mt-2 text-3xl font-bold md:text-5xl">
                Analyse your PDF with Chatbot 🤖
                {{-- <span class="text-fuchsia-400">Neon Edition</span> --}}
            </h1>
            <p class="mt-3 max-w-2xl text-sm text-slate-300 md:text-base">
                Upload a PDF, extract its content server-side, and ask grounded questions.
            </p>
        </div>

        <div class="mt-8">
            <livewire:pdf-chatbot />
        </div>
    </div>
</x-layouts.app>
