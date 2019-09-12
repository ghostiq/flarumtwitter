import SettingsModal from 'flarum/components/SettingsModal';
//import Switch from 'flarum/components/Switch';

const settingsPrefix = 'ghostiq-flarumtwitter.';
const translationPrefix = 'ghostiq-flarumtwitter.admin.settings.';

export default class TwitterSettingsModal extends SettingsModal {
    className() {
      return 'TwitterSettingsModal Modal--small';
    }

    title() {
        return app.translator.trans(translationPrefix + 'title');
    }

    form() {
        return [
            m('.Form-group', [
                m('label', app.translator.trans(translationPrefix + 'field.consumerAPI')),
                m('input.FormControl', {
                    bidi: this.setting(settingsPrefix + 'consumerAPI'),
                    placeholder: 'Consumer API Key',
                }),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans(translationPrefix + 'field.consumerAPISecret')),
                m('input.FormControl', {
                    bidi: this.setting(settingsPrefix + 'consumerAPISecret'),
                    placeholder: 'Consumer API Secret Key',
                }),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans(translationPrefix + 'field.accessToken')),
                m('input.FormControl', {
                    bidi: this.setting(settingsPrefix + 'accessToken'),
                    placeholder: 'Access Token',
                }),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans(translationPrefix + 'field.accessTokenSecret')),
                m('input.FormControl', {
                    bidi: this.setting(settingsPrefix + 'accessTokenSecret'),
                    placeholder: 'Access Token Secret',
                }),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans(translationPrefix + 'field.tagIdToFollow')),
                m('input.FormControl', {
                    bidi: this.setting(settingsPrefix + 'tagIdToFollow'),
                    placeholder: 'Tag id to follow',
                }),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans(translationPrefix + 'field.tagIdToFollow1')),
                m('input.FormControl', {
                    bidi: this.setting(settingsPrefix + 'tagIdToFollow1'),
                    placeholder: 'Another tag id to follow',
                }),
            ]),
        ];
    }
}