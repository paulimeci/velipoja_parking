<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $languages = [];

    public $currentLocale;

    public function mount()
    {
        $this->currentLocale = App::getLocale();
        $this->loadLanguages();
    }

    public function loadLanguages()
    {
        $path = base_path('lang');
        if (File::exists($path)) {
            $files = File::files($path);
            foreach ($files as $file) {
                if ($file->getExtension() === 'json') {
                    $this->languages[] = $file->getFilenameWithoutExtension();
                }
            }
        }
    }

    public function changeLocale($locale)
    {
        Session::put('locale', $locale);
        Session::save(); // Force session save

        return redirect(request()->header('Referer', '/'));
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
