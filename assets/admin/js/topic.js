import '../scss/topic.scss';
import $ from 'jquery';
import dropify from 'dropify'

$('.dropify').dropify({
    messages: {
        default: 'Glissez-d&eacute;posez un fichier ici ou cliquez',
        replace: 'Glissez-d&eacute;posez un fichier ou cliquez pour remplacer',
        remove:  'Supprimer',
        error:   'D&eacute;sol&eacute;, le fichier est trop volumineux'
    }
});