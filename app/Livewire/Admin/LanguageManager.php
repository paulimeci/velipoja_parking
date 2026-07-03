<?php

namespace App\Livewire\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class LanguageManager extends Component
{
    use AuthorizesRequests;

    public $languages = [];

    public $selectedLanguage = null;

    public $translations = [];

    public $newLanguageCode = '';

    public $showAddLanguageModal = false;

    public function mount()
    {
        $this->authorize('manage all'); // Or a specific permission if you prefer
        $this->loadLanguages();
    }

    public function loadLanguages()
    {
        $path = base_path('lang');
        $files = File::files($path);

        $this->languages = [];
        foreach ($files as $file) {
            if ($file->getExtension() === 'json') {
                $this->languages[] = $file->getFilenameWithoutExtension();
            }
        }
    }

    public function selectLanguage($code)
    {
        $this->selectedLanguage = $code;
        $path = base_path("lang/{$code}.json");
        $this->translations = json_decode(File::get($path), true);
    }

    public function addLanguage()
    {
        $this->validate([
            'newLanguageCode' => 'required|alpha|size:2|unique:languages,code', // Just a logical check, we don't have a table
        ], [
            'newLanguageCode.required' => 'Kodi i gjuhës është i detyrueshëm (p.sh. en, sq, it).',
            'newLanguageCode.size' => 'Kodi i gjuhës duhet të jetë me 2 shkronja.',
        ]);

        $code = strtolower($this->newLanguageCode);
        $newPath = base_path("lang/{$code}.json");

        if (File::exists($newPath)) {
            $this->addError('newLanguageCode', 'Kjo gjuhë ekziston tashmë.');

            return;
        }

        // Duplicate from sq.json or first available
        $sourcePath = base_path('lang/sq.json');
        if (! File::exists($sourcePath)) {
            $sourcePath = ! empty($this->languages) ? base_path("lang/{$this->languages[0]}.json") : null;
        }

        if ($sourcePath) {
            File::copy($sourcePath, $newPath);
        } else {
            File::put($newPath, json_encode([], JSON_PRETTY_PRINT));
        }

        $this->newLanguageCode = '';
        $this->showAddLanguageModal = false;
        $this->loadLanguages();
        $this->selectLanguage($code);

        session()->flash('success', 'Gjuha e re u shtua me sukses.');
    }

    public function saveTranslations()
    {
        if (! $this->selectedLanguage) {
            return;
        }

        $path = base_path("lang/{$this->selectedLanguage}.json");
        File::put($path, json_encode($this->translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        session()->flash('success', 'Përkthimet u ruajtën me sukses.');
    }

    public function render()
    {
        return view('livewire.admin.language-manager')
            ->layout('layouts.dashboard.app');
    }
}
