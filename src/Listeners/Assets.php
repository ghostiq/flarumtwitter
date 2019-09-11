<?php

namespace Ghostiq\FlarumTelegram\Listeners;

use DirectoryIterator;
use Flarum\Event\ConfigureLocales;
use Flarum\Forum\Event\Rendering;
use Illuminate\Contracts\Events\Dispatcher;

class Assets
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Rendering::class, [$this, 'addAssets']);
        $events->listen(ConfigureLocales::class, [$this, 'addLocales']);
    }

    /**
     * @param Rendering $event
     */
    public function addAssets(Rendering $event)
    {
        if ($event->isAdmin()) {
            $event->addAssets([
                __DIR__ . '/../../js/dist/admin.js',
            ]);
            $event->addBootstrapper('ghostiq/flarumtwitter/main');
        }
    }

    /**
     * Provides i18n files.
     *
     * @param ConfigureLocales $event
     */
    public function addLocales(ConfigureLocales $event)
    {
        foreach (new DirectoryIterator(__DIR__ . '/../../locale') as $file) {
            if ($file->isFile() && in_array($file->getExtension(), ['yml', 'yaml'])) {
                $event->locales->addTranslations($file->getBasename('.' . $file->getExtension()), $file->getPathname());
            }
        }
    }
}
