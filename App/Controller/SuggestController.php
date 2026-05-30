<?php

namespace App\Controller;

use App\Service\FormatService;
use App\Service\MailService;
use App\Service\SuggestService;

class SuggestController
    extends BaseController
{
    public function __construct(
        private FormatService $formatService,
        private SuggestService $suggestService,
        private MailService $mailService
    ) {}

    public function index(): void
    {
        $this->requireAuth();

        $data = [
            'pageTitle' =>
                'Suggest a media item',

            'section' =>
                'suggest',

            'hideSearch' =>
                true,

            'categories' =>
                $this
                    ->formatService
                    ->category_drop_down(),

            'formats' =>
                $this
                    ->formatService
                    ->format_array(),

            'genres' =>
                $this
                    ->formatService
                    ->genres_array(),

            'errors' => []
        ];

        if ($this->isPost()) {

            $form =
                $this
                    ->suggestService
                    ->process($_POST);

            $data =
                array_merge(
                    $data,
                    $form
                );

            if (
                empty(
                    $form['error_message']
                )
            ) {

                $this
                    ->mailService
                    ->sendSuggestion(
                        $form
                    );

                $this->redirect(
                    '?page=suggest&status=thanks'
                );
            }
        }

        $this->render(
            'suggest',
            $data
        );
    }
}