@php
    $shareLinks = getShareLinks($link);
@endphp
<div class="single-link link-card col-12 col-md-6 col-lg-4">
    <div class="h-100 card">
        <div class="link-thumbnail-list-holder-detailed">
            <a href="{{ $link->url }}" {!! linkTarget() !!} class="link-url link-thumbnail-list-detailed">
                @if($link->thumbnail)
                    <img src="{{ $link->thumbnail }}" alt="{{ $link->title }}" class="w-100 h-100 object-fit-cover" loading="lazy">
                @endif
                @if(!$link->thumbnail)
                    <span class="link-thumbnail-placeholder link-thumbnail-placeholder-detailed">
                        <x-icon.linkace-icon/>
                    </span>
                @endif
            </a>
            <input type="checkbox" aria-label="@lang('link.bulk_edit_add')" class="bulk-edit-model form-check"
                data-id="{{ $link->id }}">
        </div>

        <div class="card-body h-100 border-bottom-0">
            <a href="{{ $link->url }}" {!! linkTarget() !!} class="title two-lines">{{ $link->title }}</a>
            <div class="url mt-1 small text-pale w-100 one-line">
                {{ $link->url }}
            </div>
        </div>

        @if($link->tags->count() > 0)
            <div class="link-tags px-3 mb-3">
                @foreach($link->tags as $tag)
                    <a href="{{ route('tags.show', [$tag]) }}" class="btn btn-light btn-xs text-condensed">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="meta d-flex align-items-center my-1">
            <div class="text-pale text-xs me-3 ps-3 text-condensed">
                @lang('linkace.added') {!! $link->addedAt() !!}
            </div>

            <div class="btn-group ms-auto me-2">
                <button type="button" class="btn btn-xs btn-md-sm btn-link"
                    title="@lang('sharing.share_link')"
                    data-bs-toggle="collapse" data-bs-target="#sharing-{{ $link->id }}"
                    aria-expanded="false" aria-controls="sharing-{{ $link->id }}">
                    <x-icon.share class="fw"/>
                    <span class="visually-hidden">@lang('sharing.share_link')</span>
                </button>
                <a href="{{ route('links.show', [$link]) }}" class="btn btn-xs btn-link text-condensed"
                    title="@lang('link.show')">
                    @lang('linkace.show')
                </a>
                <a href="{{ route('links.edit', [$link]) }}" class="btn btn-xs btn-link text-condensed"
                    title="@lang('link.edit')">
                    @lang('linkace.edit')
                </a>
                <button type="submit" form="link-delete-{{ $link->id }}" title="@choice('link.delete', 1)"
                    class="btn btn-xs btn-link text-condensed">
                    @lang('linkace.delete')
                </button>
            </div>

            <form id="link-delete-{{ $link->id }}" method="POST" style="display: none;"
                action="{{ route('links.destroy', [$link->id]) }}">
                @method('DELETE')
                @csrf
                <input type="hidden" name="redirect_back" value="true">
            </form>
        </div>
        @if($shareLinks !== '')
            <div class="collapse" id="sharing-{{ $link->id }}">
                <div class="share-links my-1 mx-3">
                    {!! $shareLinks !!}
                </div>
            </div>
        @endif
    </div>
</div>
