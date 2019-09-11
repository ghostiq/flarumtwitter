import {extend} from 'flarum/extend';
import app from 'flarum/app';
import TwitterSettingsModal from './components/TwitterSettingsModal';

app.initializers.add('ghostiq-flarumtwitter', () => {
    app.extensionSettings['ghostiq-flarumtwitter'] = () => app.modal.show(new TwitterSettingsModal());
});