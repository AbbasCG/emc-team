@props([
    'view' => null,
    'edit' => null,
    'delete' => null,
    'viewLabel' => 'عرض التفاصيل',
    'editLabel' => 'تعديل',
    'deleteLabel' => 'حذف',
    'deleteConfirm' => 'هل أنت متأكد؟',
    'deleteAction' => null,
])

<div class="icon-actions" onclick="event.stopPropagation()">
    @if($view)
    <a href="{{ $view }}" class="icon-btn icon-btn-view" title="{{ $viewLabel }}" aria-label="{{ $viewLabel }}">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
    </a>
    @endif
    @if($edit)
    <a href="{{ $edit }}" class="icon-btn icon-btn-edit" title="{{ $editLabel }}" aria-label="{{ $editLabel }}">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
    </a>
    @endif
    @if($deleteAction)
    <form method="POST" action="{{ $deleteAction }}" onsubmit="return confirm('{{ $deleteConfirm }}')">
        @csrf @method('DELETE')
        <button type="submit" class="icon-btn icon-btn-delete" title="{{ $deleteLabel }}" aria-label="{{ $deleteLabel }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
    </form>
    @endif
</div>
