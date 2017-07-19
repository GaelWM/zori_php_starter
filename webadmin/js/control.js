/**
	* 	Date: 19/01/2017
		File Name:control.js
		Class Name: Control 
		Author: Gael Musikingala
		Description: This class holds almost all the javascripts control logic.
	*/


$(document).ready(function() {

    // All the select controls
    //$('.select2_single').select2({ placeholder: 'Select a state', allowClear: true });
    //$('.select2_group').select2({});
    //$('.select2_multiple').select2({ maximumSelectionLength: 4, placeholder: 'With Max Selection limit 4', allowClear: true });



    // Textarea
    function initToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times', 'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function(idx, fontName) { fontTarget.append($('<li><a data-edit= fontName ' + fontName + ' style=font-family:' + fontName + '>' + fontName + '</a></li>')); });
        $('a[title]').tooltip({
            container: 'body'
        });
        $('.dropdown-menu input').click(function() {
                return false;
            })
            .change(function() {
                $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
                this.value = '';
                $(this).change();
            });

        $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
                target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
        });

        if ('onwebkitspeechchange' in document.createElement('input')) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
                top: editorOffset.top,
                left: editorOffset.left + $('#editor').innerWidth() - 35
            });
        } else {
            $('.voiceBtn').hide();
        }
    }

    function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
            msg = 'Unsupported format ' + detail;
        } else {
            console.log('error uploading file', reason, detail);
        }
        $('<div class=\"alert\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
    }

    initToolbarBootstrapBindings();

    $('#editor').wysiwyg({
        fileUploadError: showErrorAlert
    });

    window.prettyPrint;
    prettyPrint();

    //---------------------------Tags
    function onAddTag(tag) {
        alert('Added a tag: ' + tag);
    }

    function onRemoveTag(tag) {
        alert('Removed a tag: ' + tag);
    }

    function onChangeTag(input, tag) {
        alert('Changed a tag: ' + tag);
    }

    $(document).ready(function() {
      $(':input').inputmask();
    });

    $('input[title]').tooltip({ // Adds the bootstrap tooltip function.
        container: 'body',
    });

    // $('select[title]').tooltip({ // Adds the bootstrap tooltip function.
    //     container: 'body',
    // });

    $(function () {
      $('[data-toggle=\"popover\"]').popover();
    });
    
    $('.popover-dismiss').popover({
      trigger: 'focus'
    });

});
