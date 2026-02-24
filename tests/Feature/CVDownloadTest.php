<?php

namespace Tests\Feature;

use App\Services\Contracts\FrontendInterface;
use CoreConstants;
use Tests\TestCase;

class CVDownloadTest extends TestCase
{
    public function test_it_downloads_cv_from_configured_path()
    {
        $this->app->instance(FrontendInterface::class, new class implements FrontendInterface {
            public function getAllData()
            {
                return [
                    'status' => CoreConstants::STATUS_CODE_SUCCESS,
                    'payload' => [
                        'about' => (object) [
                            'cv' => 'assets/common/default/cv/default.pdf',
                        ],
                    ],
                ];
            }

            public function getAllProjects()
            {
                return [];
            }
        });

        $response = $this->get(route('frontend.cv.download'));

        $response->assertOk();
        $response->assertDownload('Tyler_Carter_Resume.pdf');

        $downloadedFile = $response->baseResponse->getFile();
        $this->assertNotNull($downloadedFile);
        $this->assertStringStartsWith('%PDF', file_get_contents($downloadedFile->getRealPath(), false, null, 0, 4));
    }

    public function test_it_returns_404_when_cv_is_not_configured()
    {
        $this->app->instance(FrontendInterface::class, new class implements FrontendInterface {
            public function getAllData()
            {
                return [
                    'status' => CoreConstants::STATUS_CODE_SUCCESS,
                    'payload' => [
                        'about' => (object) [
                            'cv' => null,
                        ],
                    ],
                ];
            }

            public function getAllProjects()
            {
                return [];
            }
        });

        $response = $this->get(route('frontend.cv.download'));

        $response->assertNotFound();
    }
}
