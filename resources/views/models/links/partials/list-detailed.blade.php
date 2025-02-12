<div class="bulk-edit links-detailed" data-type="links">
    <form class="bulk-edit-form visually-hidden text-end" action="{{ route('bulk-edit.form') }}" method="POST">
        @csrf()
        <input type="hidden" name="type">
        <input type="hidden" name="models">
        <div class="btn-group mt-1">
            <button type="button" class="bulk-edit-submit btn btn-outline-primary btn-xs">Edit</button>
            <button type="button" class="bulk-edit-select-all btn btn-outline-primary btn-xs">Select all</button>
        </div>
    </form>
    <div class="link-list list-group mt-2">
        @foreach($links as $link)
            @include('models.links.partials.single-detailed')
        @endforeach
    </div>
</div>
