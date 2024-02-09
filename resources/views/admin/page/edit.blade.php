@php
@endphp
<x-admin-layout title="Pages" active-menu="page.{{ $page->title }}" :path="[$page->title => '']">
    <div class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card card-flush">
            <div class="card-header bg-primary">
                <h2 class="card-title text-white">
                    {{ str_replace('_', ' ', $page->title) }}
                </h2>
            </div>
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Form-->
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework flex flex-col gap-5" method="POST"
                    action="{{ route('admin:page.update', $page) }}">
                    @method('PUT')
                    @csrf
                    <textarea id="editor" style="display:none;" name="content">
                    </textarea>
                    <div id="editor-container"></div>
                    <div class="row py-5">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex">
                                <button type="reset" onclick="window.history.back()" class="btn btn-light me-3">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                </form>


            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    @push('addon-script')
        <script>
            $(document).ready(() => {
                var quill = new Quill('#editor-container', {
                    theme: 'snow'
                });
                var textarea = document.getElementById('editor');

                // Listen for text-change events in Quill and update the textarea content
                quill.on('text-change', function() {
                    textarea.value = quill.root.innerHTML;
                });

                // Optional: Set initial content for the Quill editor
                quill.clipboard.dangerouslyPasteHTML(@json($page->content));
            });
        </script>
    @endpush
</x-admin-layout>
