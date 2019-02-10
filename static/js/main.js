/*
    Functions
*/
function welcomeLanguages() {
    var time = 0;

    for (i = 1; i < 10; i++) {
        setTimeout("$('#w-ml-" + i + "').fadeOut(500)", time + 1500); 
        setTimeout("$('#w-ml-" + (i + 1) + "').fadeIn(500)", time + 2000);
        time += 2000;
    }
}

function count(input) {
    var txtVal      = $(input).val();
    var chars       = txtVal.length;
    var remaining   = 5000 - chars;

    if(remaining <= 10) {
        remaining = '<span class="text-red">' + remaining + '</span>';
    }

    $('.post-characters-remaining').html(remaining);
}

jQuery.fn.putCursorAtEnd = function() {
    return this.each(function() {
        $(this).focus()

        if (this.setSelectionRange) {
            var len = $(this).val().length * 2;
            this.setSelectionRange(len, len);
        } else {
            $(this).val($(this).val()); 
        }

        this.scrollTop = 999999;
    });
};

function readURL(input) {
    if(input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.photo-preview').attr('src', e.target.result);
            $('.photo-preview').show();
            $('.photo-preview-check').delay(500).fadeIn('200');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function autosuggest() {
    var min_length = 1; // min caracters to display the autocomplete
    var keyword = $('#search-autosuggest').val();
    if (keyword.length >= min_length) {
        $.ajax({
            url: '/ajax/autosuggest',
            type: 'GET',
            data: {keyword:keyword},
            success:function(data){
                $('#search-autosuggest-list').show();
                $('#search-autosuggest-list').html(data);
            }
        });
    } else {
        $('#search-autosuggest-list').hide();
    }
}

function set_item(item) {
    $('#search-autosuggest').val(item);
    $('#search-autosuggest-list').hide();
}

// Wheatley's beautiful code <3
function changeActive(direction) {
    // Select all the link elments in the list.
    var items = document.querySelectorAll('#search-autosuggest-list a');
    var activeIndex = null;

    // Loop through all the elements and check if any are focused.
    for(var i = 0; i < items.length; i++) {
        if(items[i] === document.activeElement) {
            activeIndex = i; break;
        }
    }

    if(activeIndex === null){
        if(direction === 'up')
            items[items.length - 1].focus();
        else
            items[0].focus();
        return;
    }

    if(direction === 'up') {
        if(activeIndex <= 0) items[items.length - 1].focus();
        else items[activeIndex - 1].focus();
    } else {
        if(activeIndex >= items.length - 1) items[0].focus();
        else items[activeIndex + 1].focus();
    }
}

function auto_grow(element) {
    element.style.height = "40px";
    element.style.height = (element.scrollHeight + 2) + "px";
}

/*
    Document ready
*/
function onReady() {
    /*
        Global
    */
    $('.show-modal').click(function(e) {
        e.preventDefault();
        var modal_id = $(this).attr('name');
        $('#' + modal_id).show();
        $('#' + modal_id + ' .modal-container').fadeIn(200);
        $('body').addClass('modal-open');
    });
      
    $('.close-modal').click(function(e) {  
        e.preventDefault();
        $('.modal').hide();
        $('.modal .modal-container').fadeOut(200);
        $('body').removeClass('modal-open');
    });

    $('.modal-shade').click(function(e) {
        e.preventDefault();
        $('.modal').hide();
        $('.modal .modal-container').fadeOut(200);
        $('body').removeClass('modal-open');
    });

    $('.tooltip').tooltipster({
        animation: 'grow',
        delay: '0',
        speed: '200',
        position: 'top'
    });

    $('abbr.timeago').timeago();

    /*
        Posts
    */
    $('.input-comment').unbind('keydown').bind('keydown', function(e) {
        if ((e.keyCode || e.which) == 13 && !e.shiftKey) {
            e.preventDefault();
            $(this).parents('form').submit();
        }
    });

    // AJAX Actions
    $('.reply-comment').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var user = $(this).attr('data-val');
        var mention = '@' + user + ' ';

        $('#comment-' + id).val(mention);
        $('#comment-' + id).focus();
        $('#comment-' + id).putCursorAtEnd();
    });

    $('.follow-post').unbind('click').bind('click', function(e) {
        e.preventDefault(); 
        var link = $(this);
        var text = link.find('.follow-post-text');
        var textIcn = link.find('.icon');
        var textVal = link.find('.follow-post-text').html();

        $.ajax({
            url: link.attr('href'),
            type: 'get',
            success: function(data) {
                if(textVal.toLowerCase() === 'subscribe') {
                    text.html('Unsubscribe');
                    textIcn.attr('class', textIcn.attr('class').replace('add', 'remove'));
                    link.attr('href', link.attr('href').replace('follow', 'unfollow'));
                } else {
                    text.html('Subscribe');
                    textIcn.attr('class', textIcn.attr('class').replace('remove', 'add'));
                    link.attr('href', link.attr('href').replace('unfollow', 'follow'));
                }
            }
        });
    });

    $('.follow-button').unbind('click').bind('click', function(e) {
        e.preventDefault();
        var link = $(this);
        var text = link.find('.follow-button-text');
        var textVal = link.find('.follow-button-text').html();

        $.ajax({
            url: link.attr('href'),
            type: 'get',
            success: function(data) {
                if(textVal.toLowerCase() === 'follow') {
                    link.removeClass('button-success');
                    link.addClass('button-warning');
                    text.html('Unfollow');
                    link.attr('href', link.attr('href').replace('follow', 'unfollow'));
                } else {
                    link.removeClass('button-warning');
                    link.addClass('button-success');
                    text.html('Follow');
                    link.attr('href', link.attr('href').replace('unfollow', 'follow'));
                }
            }
        });
    });

    var requestSent = false;

    $('.comment-form').unbind('submit').bind('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        form.find('input[name="comment"]').blur();

        if(!requestSent) {
            requestSent = true;

            $.ajax({
                url: '/ajax/comment',
                type: 'POST',
                cache: false,
                data: form.serialize(),
                success: function(data) {
                    // Add new comment html
                    form.find('.new-comment').prepend(data);
                    // Reset form
                    form.trigger('reset');
                    requestSent = false;
                }
            });
        }
    });

    $('.edit-post-form').unbind('submit').bind('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var postId = form.find('.post-id').val();
        // var newText = form.find('.post-input').val();
        // var main = form.parents('.post-main-text');
        // var p = main.find('p');

        $.ajax({
            url: '/ajax/edit-post',
            type: 'POST',
            cache: false,
            data: form.serialize(),
            success: function(data) {
                window.location.href = '/post/' + postId;
            }
        });
    });

    $('.edit-comment-form').unbind('submit').bind('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var postId = form.find('.post-id').val();
        var commentId = form.find('.comment-id').val();
        // var newText = form.find('.post-input').val();
        // var main = form.parents('.post-main-text');
        // var p = main.find('p');

        $.ajax({
            url: '/ajax/edit-comment',
            type: 'POST',
            cache: false,
            data: form.serialize(),
            success: function(data) {
                window.location.href = '/post/' + postId;
            }
        });
    });

    $('.like-post').unbind('click').bind('click', function(e) {
        e.preventDefault(); 
        var link = $(this);
        var text = link.find('.like-post-text');
        var textVal = link.find('.like-post-text').html();

        $.ajax({
            url: link.attr('href'),
            type: 'get',
            success: function(data) {
                link.parents('.post-comments-actions').find('.like-count').html(data);

                if(textVal.toLowerCase() === 'like') {
                    text.html('Unlike');
                    link.addClass('text-red pulse');
                    link.attr('href', link.attr('href').replace('like', 'unlike'));
                } else {
                    text.html('Like');
                    link.removeClass('text-red');
                    link.attr('href', link.attr('href').replace('unlike', 'like'));
                }
            }
        });
    });

    $('.like-comment').unbind('click').bind('click', function(e) {
        e.preventDefault(); 
        var link = $(this);
        var text = link.find('.like-comment-text');
        var textVal = link.find('.like-comment-text').html();

        $.ajax({
            url: link.attr('href'),
            type: 'get',
            success: function(data) {
                link.parents('.posted').find('.comment-like-count').html(data);

                if(textVal.toLowerCase() === 'like') {
                    text.html('Unlike');
                    link.addClass('text-red pulse');
                    link.attr('href', link.attr('href').replace('like', 'unlike'));
                } else {
                    text.html('Like');
                    link.removeClass('text-red');
                    link.attr('href', link.attr('href').replace('unlike', 'like'));
                }
            }
        });a
    });

    $('.delete-post').unbind('click').bind('click', function(e) {
        e.preventDefault();
        var link = $(this);
        var answer = confirm('Are you sure you want to delete this post?');

        if(answer) {
            $.ajax({
                url: link.attr('href'),
                type: 'get',
                success: function(data) {
                    link.parents('.post').fadeOut(function() {
                        $(this).remove();
                    });
                }
            });
        } else {
            console.log('cancel');
        }
    });

    $('.delete-comment').unbind('click').bind('click', function(e) {
        e.preventDefault();
        var link = $(this);
        var answer = confirm('Are you sure you want to delete this comment?');

        if(answer) {
            $.ajax({
                url: link.attr('href'),
                type: 'get',
                success: function(data) {
                    link.parents('.post-comment').fadeOut(function() {
                        $(this).remove();
                    });
                }
            });
        } else {
            console.log('cancel');
        }
    });

    $('.report-post').unbind('click').bind('click', function(e) {
        e.preventDefault();
        var link = $(this);
        var answer = confirm('Are you sure you want to report this post?');

        if(answer) {
            $.ajax({
                url: link.attr('href'),
                type: 'get',
                success: function(data) {
                    alert('You have successfully reported this post. Moderators will review this report as soon as possible.');
                }
            });
        } else {
            console.log('cancel');
        }
    });

    $('.report-comment').unbind('click').bind('click', function(e) {
        e.preventDefault();
        var link = $(this);
        var answer = confirm('Are you sure you want to report this comment?');

        if(answer) {
            $.ajax({
                url: link.attr('href'),
                type: 'get',
                success: function(data) {
                    alert('You have successfully reported this comment. Moderators will review this report as soon as possible.');
                }
            });
        } else {
            console.log('cancel');
        }
    });

    $('.report-user').unbind('click').bind('click', function(e) {
        e.preventDefault();
        var link = $(this);
        var answer = confirm('Are you sure you want to report this user?');

        if(answer) {
            $.ajax({
                url: link.attr('href'),
                type: 'get',
                success: function(data) {
                    alert('You have successfully reported this user. Moderators will review this report as soon as possible.');
                }
            });
        } else {
            console.log('cancel');
        }
    });
}


$(document).ready(function() {

    /*
        Subheader Logic
        Written by @wheatley
    */
    var mainheader = document.querySelector('.header');
    var subheader = document.querySelector('.tab-subheader-inner');

    var lastScrollPosition = 0;
    var scrollThreshold = 0;
    var isFixed = false;
  
    function onDocumentScroll(e) {
        var currentScrollPosition = (window.pageYOffset || document.documentElement.scrollTop) - (document.documentElement.clientTop || 0);    

        subheader.style.transition = (isFixed ? '' : 'none');

        if(currentScrollPosition > subheader.clientHeight) {
            subheader.style.position = 'fixed';
            isFixed = true;

            if(currentScrollPosition > lastScrollPosition + scrollThreshold)
                subheader.style.transform = 'translateY(-100%)';

            if(currentScrollPosition < lastScrollPosition - scrollThreshold)
                subheader.style.transform = 'translateY(0)';
        }

        if(currentScrollPosition === 0) {
            subheader.style.position = 'relative';
            subheader.style.transform = 'translateY(0)';
            isFixed = false;
        }

        lastScrollPosition = currentScrollPosition;
    }
  
    document.addEventListener('scroll', onDocumentScroll, { passive: true });

    /*
        Global
    */
    $('.message-close').click(function(e) {
        e.preventDefault();
        $('.messages').slideUp(400);
    });
    
    /* 
        Header
    */
    $('.search-bar').keydown(function(e) {
        if(e.keyCode == 40) {
            changeActive('down');
            e.preventDefault();
        }

        if(e.keyCode == 38) {
            changeActive('up');
            e.preventDefault();
        }
    });

    $(document).mouseup(function(e) {
        if (!$('.search-bar').is(e.target) && $('.search-bar').has(e.target).length === 0) {
            $('#search-autosuggest-list').hide();
        }
    });

    $('.search-bar-input').keyup(function(e) {
        autosuggest();
        this.setAttribute('value', this.value);
    });

    $('.messages-dropdown-toggle').click(function(e) {
        e.preventDefault();
        $('.messages-dropdown').fadeToggle(50);

        $(document).mouseup(function(e) {
            var dropdown = $('.messages-dropdown');
            var toggle = $('.messages-dropdown-toggle');

            if(!dropdown.is(e.target) && toggle.has(e.target).length === 0 && dropdown.has(e.target).length === 0) {
                dropdown.fadeOut(50);
            }
        });
    });

    $('.notifications-dropdown-toggle').click(function(e) {
        e.preventDefault();
        $('.notifications-dropdown').fadeToggle(50);

        $.ajax({
            url: '/ajax/notifications?read=all',
            type: 'POST',
            cache: false,
            success: function(data) {
                $('.notification-badge').hide();
            }
        });

        $(document).mouseup(function(e) {
            var dropdown = $('.notifications-dropdown');
            var toggle = $('.notifications-dropdown-toggle');

            if(!dropdown.is(e.target) && toggle.has(e.target).length === 0 && dropdown.has(e.target).length === 0) {
                dropdown.fadeOut(50);
            }
        });
    });

    $('.user-dropdown-toggle').click(function(e) {
        e.preventDefault();
        $('.user-dropdown').fadeToggle(50);

        $(document).mouseup(function(e) {
            var dropdown = $('.user-dropdown');
            var toggle = $('.user-dropdown-toggle');

            if (!dropdown.is(e.target) && toggle.has(e.target).length === 0 && dropdown.has(e.target).length === 0) {
                dropdown.fadeOut(50);
            }
        });
    });

    /*
        Posts
    */

    // Allow tab character in textareas.
    $(document).delegate('textarea', 'keydown', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode == 9) {
            e.preventDefault();
            var start = $(this).get(0).selectionStart;
            var end = $(this).get(0).selectionEnd;

            // set textarea value to: text before caret + tab + text after caret
            $(this).val($(this).val().substring(0, start) + "\t" + $(this).val().substring(end));

            // put caret at right position again
            $(this).get(0).selectionStart = $(this).get(0).selectionEnd = start + 1;
        }
    });

    $('#post-input').focus(function() {
        $(this).animate({
            height: '200px'
        }, 200, function() {
            $(this).css({
                'overflow': 'scroll',
                'border-radius': '4px 4px 0px 0px'
            });
        });

        $('.post-main-footer').show();
    });

    $('.post-input').on('keyup propertychange paste', function() { 
        count('.post-input');
    });

    $("#add-photo-button").click(function(e) {
        e.preventDefault();
        $("#add-photo").click();
    });
    $('#add-photo').change(function() {
        readURL(this);
    });

    $('.photo-preview').on('error', function() { 
        $('.photo-preview').attr('src', '');
        $('.photo-preview-check').remove();
    });

    /*
        Pages
    */
    welcomeLanguages();

    /*
        Footer
    */
    $('#show-modal-language').click(function(e) { e.preventDefault(); $('.modal-language').fadeIn(200); $('.modal-language .modal-container').fadeIn(200); });
    $('#close-modal-language').click(function(e) { e.preventDefault(); $('.modal-language').fadeOut(200); $('.modal-language .modal-container').fadeOut(200); });

    onReady();
});

/*
    Load More (posts)
*/
function loadmore(source) {
    var stepped = 1;
    var step = 15;

    function load(start, count) {
        $.ajax({
            url: source,
            type: 'get',
            dataType: 'text',
            data: {start: start, count: count},
            success: function(data) {
                var items = data;
                $('.posts').append(data);
                stepped = start + count;
                onReady();
            }
        });
    }

    $('.posts-load').on('click', function(e) {
        e.preventDefault();
        load(stepped, step);
    });

    load(1, 15);
}