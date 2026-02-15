<script type="module">
    import {Uppy, Dashboard, ImageEditor, DropTarget, XHRUpload} from "{{ staticAsset('backend/assets/js/vendors/uppy.min.js') }}"
    var uppy = new Uppy({
            restrictions: { 
                allowedFileTypes: TT.allowedFileTypes, 
            }
        })
        .use(Dashboard, {
            inline: true,
            target: '.uppy-drag-drop-area',
            proudlyDisplayPoweredByUppy: false,
            hidePauseResumeButton: true,
            width: '100%',
            height:'auto'
        })
        .use(ImageEditor, { target: Dashboard })
        // Allow dropping files on any element or the whole document
        .use(DropTarget, { 
            target: 'DashboardContainer'
        })
        .use(XHRUpload, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            endpoint: TT.baseUrl+'/media-manager/add-files',
            fieldName: "media_file",
            formData: true,
        })

    uppy.on('complete', (result) => {
        getMediaFiles();
    })
</script>

<script>
    "use strict";

    // required
    TT.getMediaType = 'all';
    TT.getMediaSearch = '';
    TT.allowedFileTypes = [
        ".png",
        ".svg",
        ".gif",
        ".jpg",
        ".jpeg",
        ".webp"
    ];

    TT.uploadQty = "single";
    TT.selectedFiles = null;
    TT.nextPageUrl = null;
    // required 

    // get the media files via ajax
    async function getMediaFiles(getMediaType = TT.getMediaType, getMediaSearch = TT.getMediaSearch, search = false) {

        let url = '{{ route('uppy.index') }}';

        if (search == false) {
            $('.recent-uploads').empty();
        }

        $('.previous-uploads').empty();

        // get media files
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: "GET",
            data: {
                type: getMediaType,
                searchKey: search ? getMediaSearch : '',
            },
            url: url,
            success: function(data) {

                if (search == false) {
                    $('.recent-uploads').append(data.recentFiles); // if !searched
                }
                $('.previous-uploads').append(data.mediaFiles);


                TT.nextPageUrl = data.mediaQuery.next_page_url;
                if (data.mediaQuery.next_page_url == null) {
                    $('.load-more-media').addClass('d-none')
                } else {
                    $('.load-more-media').removeClass('d-none')
                }

                // show selected counter in the media manager
                getSelectedFilesCount();

                // add active class when initialized --> delay to ready the document
                setTimeout(() => {
                    activeSelectedFiles();
                }, 400);
                initFeather();
            }
        });
    }

    // get next paginated files
    function getNextMediaFiles() {
        if (TT.nextPageUrl != null) {
            // get media files
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "GET",
                url: TT.nextPageUrl,
                success: function(data) {

                    $('.previous-uploads').append(data.mediaFiles);

                    TT.nextPageUrl = data.mediaQuery.next_page_url;

                    if (data.mediaQuery.next_page_url == null) {
                        $('.load-more-media').addClass('d-none')
                    } else {
                        $('.load-more-media').removeClass('d-none')
                    }
                    // show selected counter in the media manager
                    getSelectedFilesCount();

                    // add active class when initialized --> delay to ready the document
                    setTimeout(() => {
                        activeSelectedFiles();
                    }, 400);
                    initFeather();
                }
            });
        }
    }

    // get the media files via ajax
    async function getSelectedMediaFiles(mediaIds, target = TT.showSelectedFilesDiv) {
        // get media files
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: "GET",
            data: {
                mediaIds: mediaIds,
            },
            url: '{{ route('uppy.selectedFiles') }}',
            success: function(data) {

                if (TT.uploadQty = "single") {
                    target.children().not('.choose-media').remove();
                }

                target.prepend(data.mediaFiles);
                initFeather();
            }
        });
    }

    // show media manager
    async function showMediaManager(thisWrapper) {
        // handle -> click chose file
        let selectedFilesInput = $(thisWrapper).find('input');
        TT.uploadQty = $(thisWrapper).data("selection");

        TT.selectedFiles = selectedFilesInput.val() != '' ? selectedFilesInput.val() : null;
        TT.selectedFilesInput = selectedFilesInput;

        TT.showSelectedFilesDiv = $(thisWrapper).parent();
        // handle -> click chose file

        // show media manager showMediaManager()

        // invoke media file fetching function
        await getMediaFiles();
    }

    // add active class to the selected files
    function activeSelectedFiles() {
        if (TT.selectedFiles != null) {
            TT.selectedFiles
                .split(",").forEach(selectedImage => {
                    $('[data-active-file-id=' + selectedImage + ']').addClass('active-image');
                });
        }
    }

    // on click event handler of files 
    function handleSelectedFiles(fileId) {
        $('[data-active-file-id!=' + fileId + ']').removeClass('active-image'); // remove active class 
        if (TT.uploadQty == "single") {
            TT.selectedFiles = '' + fileId + ''
        } else {
            if (TT.selectedFiles != null) {
                let tempSelected = TT.selectedFiles.split(",");

                if (tempSelected.includes('' + fileId + '')) {

                    tempSelected = tempSelected.filter(tempId => {
                        return tempId != '' + fileId + ''
                    })

                    $('[data-active-file-id=' + fileId + ']').removeClass(
                        'active-image'); // remove active class

                } else {
                    tempSelected.push(fileId);
                }

                if (tempSelected.length > 0) {
                    TT.selectedFiles = tempSelected.toString();
                } else {
                    TT.selectedFiles = null;
                }

            } else {
                TT.selectedFiles = '' + fileId + ''
            }
        }
        activeSelectedFiles();
        getSelectedFilesCount();
    }

    // show the selected file count in the media manager card-header
    function getSelectedFilesCount() {
        //  
    }

    // show the chosen file count in specific pages
    function getChosenFilesCount() {
        //  
    }

    // show selected files preview after selecting files from media manager
    function showSelectedFilePreview() {
        // for file chosen input counter 
        TT.selectedFilesInput.val(TT.selectedFiles);
        generatePreview();
        hideMediaManager();
    }

    // show selected file preiview on load in specific pages
    function showSelectedFilePreviewOnLoad() {
        $('.choose-media').each(function() {
            let showSelectedFilesDiv = $(this).parent();
            let selectedFiles = $(this).find('input').val();
            generatePreview(selectedFiles, showSelectedFilesDiv)
        });
    }

    // remove (after clicking remove button) selected file in specific pages 
    function removeSelectedFile(thisButton, mediaFileId) {
        let removeFileDiv = $(thisButton).closest('.selected-file'); //removeFileDiv.remove();
        let showSelectedFilesDiv = removeFileDiv.parent(); // .show-selected-files
        let choseMediaDiv = showSelectedFilesDiv.find('.choose-media'); //choose media button

        let selectedFilesInput = $(choseMediaDiv).find('input');
        let selectedFiles = selectedFilesInput.val();

        if (selectedFiles != null && selectedFiles != '') {
            let tempSelected = selectedFiles.split(",");

            tempSelected = tempSelected.filter(tempId => {
                return tempId != '' + mediaFileId + ''
            })

            $('[data-active-file-id=' + mediaFileId + ']').removeClass('active-image'); // remove active class  
            selectedFilesInput.val(tempSelected);
        }
        removeFileDiv.remove();
    }

    // generate preview
    function generatePreview(mediaIds = TT.selectedFiles, target = TT.showSelectedFilesDiv) {
        if (mediaIds && mediaIds != '') {
            mediaIds = mediaIds.split(',');
            getSelectedMediaFiles(mediaIds, target);
        }
    }

    // hide media manager
    function hideMediaManager() {}

    // media search
    $('#media-search-from').on('submit', function(e) {
        e.preventDefault();
        TT.getMediaSearch = $('input[name=media-search]').val();
        getMediaFiles(TT.getMediaType, TT.getMediaSearch, TT.getMediaSearch != '' ? true : false);
    })

    // Bulk Delete Logic
    window.toggleSelectAll = function() {
        let allVisibleIds = [];
        $('.tt-media-item').each(function() {
            allVisibleIds.push($(this).data('active-file-id').toString());
        });
        
        if (allVisibleIds.length === 0) return;

        let currentSelected = TT.selectedFiles ? TT.selectedFiles.split(',') : [];
        
        // Check if all visible are selected
        let allSelected = allVisibleIds.every(id => currentSelected.includes(id));

        if (allSelected) {
            // Deselect All Visible
            currentSelected = currentSelected.filter(id => !allVisibleIds.includes(id));
            $('.tt-media-item').removeClass('active-image');
            $('#selectAllText').text('{{ localize("Select All") }}');
        } else {
            // Select All Visible
            // Add any visible IDs that aren't already in the list
            allVisibleIds.forEach(id => {
                if (!currentSelected.includes(id)) {
                    currentSelected.push(id);
                }
            });
            $('.tt-media-item').addClass('active-image');
            $('#selectAllText').text('{{ localize("Deselect All") }}');
        }
        
        TT.selectedFiles = currentSelected.length > 0 ? currentSelected.join(',') : null;
        updateBulkDeleteButton();
    }

    function updateBulkDeleteButton() {
         if (TT.selectedFiles && TT.selectedFiles.length > 0) {
            $('#bulkDeleteBtn').removeClass('d-none');
        } else {
            $('#bulkDeleteBtn').addClass('d-none');
        }
    }

    // Override or hook into handleSelectedFiles to update button state
    // We need to redefine handleSelectedFiles because the original one doesn't call our update function
    // But since it's defined in the same scope, we can just replace it or wrap it. 
    // However, the original is defined as a function declaration which is hoisted. 
    // To be safe, we'll redefine it here but make sure it does what the original did + our update.

    // Redefining handleSelectedFiles
    window.handleSelectedFiles = function(fileId) {
        // If uploadQty is single, we shouldn't allow multi-select unless we are in "bulk delete mode"
        // But wait, the media manager is reused for selecting product images (multi) and avatars (single).
        // If we are just in the media manager page, we want multi-select for deletion.
        // We can check if we are in the standalone media manager page. 
        // Logic: if button #bulkDeleteBtn exists in DOM, we allow multi-select behavior for deletion?
        // Actually, let's just use the existing logic but ensure multi-select is enabled if we are on the manager page.
        
        // Check if we are on the main media manager page (not a modal)
         const isMediaManagerPage = $('#bulkDeleteBtn').length > 0;

         if (isMediaManagerPage) {
             TT.uploadQty = 'multiple'; // Force multiple selection mode on this page
         }

        $('[data-active-file-id!=' + fileId + ']').removeClass('active-image'); // remove active class 
        if (TT.uploadQty == "single") {
            TT.selectedFiles = '' + fileId + ''
        } else {
            if (TT.selectedFiles != null) {
                let tempSelected = TT.selectedFiles.split(",");

                if (tempSelected.includes('' + fileId + '')) {

                    tempSelected = tempSelected.filter(tempId => {
                        return tempId != '' + fileId + ''
                    })

                    $('[data-active-file-id=' + fileId + ']').removeClass(
                        'active-image'); // remove active class

                } else {
                    tempSelected.push(fileId);
                }

                if (tempSelected.length > 0) {
                    TT.selectedFiles = tempSelected.toString();
                } else {
                    TT.selectedFiles = null;
                }

            } else {
                TT.selectedFiles = '' + fileId + ''
            }
        }
        activeSelectedFiles();
        // getSelectedFilesCount(); // existing function is empty
        updateBulkDeleteButton(); // NEW
    }

    function confirmBulkDelete() {
        if (!TT.selectedFiles) return;
        
        if(confirm('{{ localize("Are you sure you want to delete these files?") }}')) {
            $.ajax({
                url: '{{ route("uppy.bulkDelete") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    media_ids: TT.selectedFiles.split(',')
                },
                success: function(res) {
                    if(res.success) {
                        // Refresh the list
                         TT.selectedFiles = null;
                         updateBulkDeleteButton();
                         getMediaFiles();
                         // alert(res.message);
                    }
                },
                error: function(err) {
                    console.error(err);
                    alert('{{ localize("Something went wrong") }}');
                }
            });
        }
    }
</script>
