import '../scss/topic.scss';

import $ from 'jquery';
import dropify from 'dropify';
import Swal from 'sweetalert2';

// ------------------------------------- Dropify ------------------------------------- //

$('.dropify').dropify({
    messages: {
        default: 'Glissez-d&eacute;posez un fichier ici ou cliquez',
        replace: 'Glissez-d&eacute;posez un fichier ou cliquez pour remplacer',
        remove: 'Supprimer',
        error: 'D&eacute;sol&eacute;, le fichier est trop volumineux'
    }
});

// ------------------------------------- Topic Delete Alert ------------------------------------- //

$('#deleteTopic').click(function () {
    const redirectLink = $(this).attr('data-link');
    Swal.fire({
        title: 'Êtes-vous sûrs ?',
        text: 'Vous supprimerez également l\'éclairage, les commentaires et les contributions.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, je confirme !',
        confirmButtonColor: "#DD6B55",
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                    title: 'Supprimé!',
                    text: 'Suppression en cours... Patientez.',
                    showConfirmButton: false,
                    icon: 'success',
                    timer: 2000
                }
            ).then(() => {
                window.location.href = redirectLink;
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Annulation',
                'La suppression a bien été annulé.',
                'error'
            );
        }
    });
});

// ------------------------------------- Handle XHR Comment Submit ------------------------------------- //

$('form[name=rsv_comment]').submit(function (e) {

    // -- Stop HTTP redirect
    e.preventDefault();

    // -- Reset errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('.alert-danger').remove();

    // -- Récupération des Champs
    const comment = $('#rsv_comment_content');

    // -- Check comment Length
    if (comment.val().length === 0) {
        comment.addClass('is-invalid');
        $('<div class="invalid-feedback">Vous devez rédiger une contribution.</div>').appendTo(comment.parent());
    }

    // -- If no errors proceed Ajax Call
    if ($(this).find('.is-invalid').length === 0) {

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'JSON',
            timeout: 5000,
        })
            .done((data) => {
                if (data.status) {

                    // Remove alert if any
                    $('.alert.alert-info').remove();

                    // Increment contribution number
                    var el = parseInt($('.badge.badge-pill.badge-primary').text());
                    $('.badge.badge-pill.badge-primary').text(el+1);

                    // Update interface
                    if ($('#contribution .profiletimeline').length > 0) {

                        $('#contribution .profiletimeline').append(`
                            <div class="sl-item">
                                <div class="sl-left"><img src="/assets/images/user-profil.png" alt="user" class="img-circle"/></div>
                                <div class="sl-right">
                                    <div>
                                        <a href="javascript:void(0)" class="link">${data.user.firstname} ${data.user.lastname}</a>
                                        <time datetime="${data.comment.writingDate}" class="sl-date"><span>A l'instant</span></time>
                                        <p>${data.comment.content}</p>
                                    </div>
                                </div>
                            </div>
                        `);

                    } else {

                        $('#contribution').prepend(`
                            <div class="card-body">
                                <div class="profiletimeline">
                                    <div class="sl-item">
                                        <div class="sl-left"><img src="/assets/images/user-profil.png" alt="user" class="img-circle"/></div>
                                        <div class="sl-right">
                                            <div>
                                                <a href="javascript:void(0)" class="link">${data.user.firstname} ${data.user.lastname}</a>
                                                <time datetime="${data.comment.writingDate}" class="sl-date"><span>A l'instant</span></time>
                                                <p>${data.comment.content}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                    }

                    // Reset form
                    $('form[name=rsv_comment]').get(0).reset();

                } // Fin if status tru
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.log('Une erreur est survenue : ' + errorThrown);
                $(this).prepend(`
            <div class="alert alert-danger text-center">
                <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><br>
                Attention, Nous n'avons pas été en mesure de traiter votre demande.
            </div>
        `);
            });

    } // End if find is-invalid


});

// -------------- ADMIN COMMENT --------------//

$('form[name=rsv_admin_comment]').submit(function (e) {

    // -- Stop HTTP redirect
    e.preventDefault();

    // -- Reset errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('.alert-danger').remove();

    // -- Récupération des Champs
    const comment = $('#rsv_admin_comment_content');

    // -- Check comment Length
    if (comment.val().length === 0) {
        comment.addClass('is-invalid');
        $('<div class="invalid-feedback">Vous devez rédiger une demande.</div>').appendTo(comment.parent());
    }

    // -- If no errors proceed Ajax Call
    if ($(this).find('.is-invalid').length === 0) {

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'JSON',
            timeout: 5000,
        })
            .done((data) => {
                if (data.status) {

                    // Remove alert if any
                    $('.alert.alert-info').remove();

                    // Update interface
                    if ($('#private .profiletimeline').length > 0) {

                        $('#private .profiletimeline').append(`
                            <div class="sl-item">
                                <div class="sl-left"><img src="/assets/images/user-profil.png" alt="user" class="img-circle"/></div>
                                <div class="sl-right">
                                    <div>
                                        <a href="javascript:void(0)" class="link">${data.user.firstname} ${data.user.lastname}</a>
                                        <time datetime="${data.comment.writingDate}" class="sl-date"><span>A l'instant</span></time>
                                        <p>${data.comment.content}</p>
                                    </div>
                                </div>
                            </div>
                        `);

                    } else {

                        $('#private').prepend(`
                            <div class="card-body">
                                <div class="profiletimeline">
                                    <div class="sl-item">
                                        <div class="sl-left"><img src="/assets/images/user-profil.png" alt="user" class="img-circle"/></div>
                                        <div class="sl-right">
                                            <div>
                                                <a href="javascript:void(0)" class="link">${data.user.firstname} ${data.user.lastname}</a>
                                                <time datetime="${data.comment.writingDate}" class="sl-date"><span>A l'instant</span></time>
                                                <p>${data.comment.content}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                    }

                    // Reset form
                    $('form[name=rsv_admin_comment]').get(0).reset();

                } // Fin if status tru
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.log('Une erreur est survenue : ' + errorThrown);
                $(this).prepend(`
            <div class="alert alert-danger text-center">
                <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><br>
                Attention, Nous n'avons pas été en mesure de traiter votre demande.
            </div>
        `);
            });

    } // End if find is-invalid


});

// ------------------------------------- Display Date with Moment ------------------------------------- //

import * as moment from 'moment';
import 'moment/locale/fr';

$('time.sl-date').each(function (t, e) {
    const time = moment($(e).attr('datetime'));
    $(e).html('<span>' + time.from(moment()) +'</span>');
});