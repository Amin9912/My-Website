document.addEventListener('DOMContentLoaded', function () {

    $(document).on('click', '#addRowBtn', function () {
        var date = new Date()
        var target = $(this).attr('target')
        var name = $(this).attr('data-name')
        var title = $(this).attr('data-title')
        var totalRows = $(target + ' .col-lg-6').length // Count the number of rows with class 'education-row'
        var newRowId = totalRows + 1 // Create a unique id for the new row
        console.log(target);

        // Define the new row HTML
        var newRow =
            `
                <div class="col-lg-6" id="${name}${newRowId}">
                    <label for="${name}">${title} ${newRowId}</label>
                    <textarea name="${name}[${newRowId}]" class="form-control html-editor" id="${name}_info_` +
            date.getTime() +
            `"></textarea>
                        </div>
                `
        $(target).append(newRow)

        tinymce.init({
            selector: '.html-editor'
        })
    })

    $(document).on('click', '#removeEduRowBtn', function () {
        var target = $(this).attr('target')
        var remove_target = $(this).attr('remove-target')
        var totalRows = $(target + ' .col-lg-6').length

        console.log('#' + remove_target + totalRows)
        $('#' + remove_target + totalRows).remove()
    })

})
