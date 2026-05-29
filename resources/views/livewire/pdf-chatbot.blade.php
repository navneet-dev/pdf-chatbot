<div class="grid gap-6 lg:grid-cols-3">
    <div class="glass-panel rounded-2xl p-5 lg:col-span-1">
        <form wire:submit="uploadPdf" class="space-y-4">
            <label class="block text-sm font-medium text-cyan-200" for="pdf">Upload PDF</label>
            <input id="pdf" type="file" wire:model="pdf" accept="application/pdf" class="block w-full rounded-lg border border-cyan-400/40 bg-slate-900/80 p-2 text-sm text-slate-200 file:mr-3 file:rounded-md file:border-0 file:bg-cyan-500/20 file:px-3 file:py-1 file:text-cyan-200">
            <div wire:loading wire:target="pdf" class="flex items-center gap-2 text-xs text-cyan-200">
                <span class="h-3 w-3 animate-spin rounded-full border-2 border-cyan-300/40 border-t-cyan-200"></span>
                Preparing file...
            </div>
            @error('pdf')
                <p class="text-sm text-rose-300">{{ $message }}</p>
            @enderror
            @if (session('status'))
                <p class="text-sm text-emerald-300">{{ session('status') }}</p>
            @endif
            <button type="submit" class="w-full rounded-lg border border-cyan-400/40 bg-cyan-500/20 px-4 py-2 text-sm font-semibold text-cyan-100 transition hover:bg-cyan-500/30 disabled:cursor-not-allowed disabled:opacity-60" wire:loading.attr="disabled" wire:target="uploadPdf,pdf">
                <span wire:loading.remove wire:target="uploadPdf,pdf">Parse PDF</span>
                <span wire:loading wire:target="uploadPdf,pdf" class="inline-flex items-center gap-2">
                    <span class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-cyan-200/40 border-t-cyan-100"></span>
                    Uploading and parsing...
                </span>
            </button>
            <p wire:loading wire:target="uploadPdf" class="text-xs text-cyan-100/90">
                Parsing PDF content. This may take a few seconds for larger files.
            </p>
        </form>

        <form wire:submit="ask" class="space-y-4">
            <label class="block text-sm font-medium text-fuchsia-200 mt-6" for="question">Ask a question</label>
            <textarea id="question" wire:model="question" rows="5" class="w-full rounded-lg border border-fuchsia-400/40 bg-slate-900/80 p-3 text-sm text-slate-100 placeholder-slate-400 outline-none transition focus:border-fuchsia-300" placeholder="What is this PDF about?"></textarea>
            @error('question')
                <p class="text-sm text-rose-300">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full rounded-lg border border-fuchsia-400/40 bg-fuchsia-500/20 px-4 py-2 text-sm font-semibold text-fuchsia-100 transition hover:bg-fuchsia-500/30 disabled:cursor-not-allowed disabled:opacity-60" @disabled($processing)>
                <span wire:loading.remove wire:target="ask">Get your answer</span>
                <span wire:loading wire:target="ask" class="inline-flex items-center gap-2">
                    <span class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-fuchsia-200/40 border-t-fuchsia-100"></span>
                    Querying...
                </span>
            </button>
            <p wire:loading wire:target="ask" class="text-xs text-fuchsia-100/90">
                Analyzing your PDF context and generating an answer...
            </p>
        </form>
    </div>

    <div id="conversation-pane" class="glass-panel rounded-2xl p-5 lg:col-span-2" style="max-height: calc(100vh - 220px); overflow-y:auto;">
        <h2 class="text-lg font-semibold text-cyan-100">Conversation</h2>
        <div id="messages" class="mt-4 space-y-4">
            @forelse ($messages as $message)
                <div class="rounded-xl border border-cyan-300/20 bg-slate-900/70 p-4">
                    <p class="text-sm font-semibold text-cyan-200">Q: {{ $message['question'] }}</p>
                    <p class="mt-2 whitespace-pre-wrap text-sm text-slate-200">A: {{ $message['answer'] }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-400">No messages yet. Upload a PDF and ask your first question.</p>
            @endforelse
        </div>
    </div>
</div>
<script>
    (function(){
        const pane = document.getElementById('conversation-pane');
        const messages = document.getElementById('messages');
        if(!pane || !messages) return;
        const scrollToBottom = (smooth=false) => {
            try {
                pane.scrollTo({ top: pane.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
            } catch (e) {
                pane.scrollTop = pane.scrollHeight;
            }
        };
        // initial scroll on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => scrollToBottom(false));
        } else {
            scrollToBottom(false);
        }
        // observe DOM changes (new messages)
        const observer = new MutationObserver(() => scrollToBottom(true));
        observer.observe(messages, { childList: true, subtree: true });
        // also hook into Livewire updates if available
        if (window.Livewire && typeof Livewire.hook === 'function') {
            Livewire.hook('message.processed', () => scrollToBottom(true));
        }
    })();
</script>
