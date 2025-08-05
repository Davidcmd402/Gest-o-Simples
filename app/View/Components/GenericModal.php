<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GenericModal extends Component
{
    public $id;
    public $title;
    public $size;
    public $showFooter;

    public function __construct($id, $title = null, $size = '', $showFooter = true)
    {
        $this->id = $id; // ID único do modal
        $this->title = $title; // Título (opcional)
        $this->size = $size; // Tamanho (ex: modal-lg)
        $this->showFooter = $showFooter; // Mostra ou não o rodapé
    }

    public function render()
    {
        return view('components.generic-modal');
    }
}
