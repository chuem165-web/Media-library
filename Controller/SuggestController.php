<?php

class SuggestController
    extends BaseController
{
    private FormatService
        $formatService;

    private SuggestService
        $suggestService;

    private MailService
        $mailService;

    public function __construct(
        FormatService $formatService,
        SuggestService $suggestService,
        MailService $mailService
    ) {

        $this->formatService =
            $formatService;

        $this->suggestService =
            $suggestService;

        $this->mailService =
            $mailService;
    }

    public function index(): void
    {

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
                    ->genres_array()
        ];

        if (
            $_SERVER[
                'REQUEST_METHOD'
            ] === 'POST'
        ) {

            $form =
                $this
                ->suggestService
                ->process(
                    $_POST
                );

            $data =
                array_merge(
                    $data,
                    $form
                );

            if (
                empty(
                    $form[
                        'error_message'
                    ]
                )
            ) {

                $this
                    ->mailService
                    ->sendSuggestion(
                        $form
                    );

                $this->redirect(
                    'index.php?page=suggest&status=thanks'
                );
            }
        }

        $this->render(
            'suggest',
            $data
        );
    }
}