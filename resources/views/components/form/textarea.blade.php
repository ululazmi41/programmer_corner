<div class="
    grid
    text-sm
    after:px-3.5
    after:py-2.5
    [&>textarea]:text-inherit
    after:text-inherit
    [&>textarea]:resize-none
    [&>textarea]:overflow-hidden
    [&>textarea]:[grid-area:1/1/2/2]
    after:[grid-area:1/1/2/2]
    after:whitespace-pre-wrap
    after:invisible
    after:content-[attr(data-cloned-val)_'_']
    after:border">
    <textarea
        class="text-xs lg:text-sm mt-4 w-full text-slate-600 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded px-3.5 py-2.5 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
        name="{{ $name }}"
        id="{{ $id }}"
        rows="2"
        onInput="this.parentNode.dataset.clonedVal = this.value"
        placeholder="Your comment..."
        required 
    ></textarea>
</div>