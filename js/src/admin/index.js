import app from 'flarum/admin/app';

import Link from '../common/models/Link';
import LinksPage from './components/LinksPage';

export * from './components';
export * from '../common/utils';
export * from '../common/models';

export { default as extend } from '../common/extend';

app.initializers.add('gtdxyz-ui-links', () => {
  app.store.models.links = Link;
  
  app.extensionData
    .for('gtdxyz-ui-links')
    .registerPage(LinksPage)
    .registerSetting({
      setting: 'gtdxyz-ui-links.show_icons_only_on_mobile',
      label: app.translator.trans('flarum-ui-links.admin.settings.show_icons_only_on_tablet'),
      help: app.translator.trans('flarum-ui-links.admin.settings.show_icons_only_on_tablet'),
      type: 'boolean',
    });
    
});
