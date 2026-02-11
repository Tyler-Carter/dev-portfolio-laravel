<?php

namespace Database\Seeders;

use CoreConstants;
use App\Services\Contracts\AboutInterface;
use App\Services\Contracts\EducationInterface;
use App\Services\Contracts\ExperienceInterface;
use App\Services\Contracts\MessageInterface;
use App\Services\Contracts\PortfolioConfigInterface;
use App\Services\Contracts\ProjectInterface;
use App\Services\Contracts\ServiceInterface;
use App\Services\Contracts\SkillInterface;
use App\Services\Contracts\VisitorInterface;
use Config;
use Illuminate\Database\Seeder;
use Log;
use Str;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $portfolioConfig = resolve(PortfolioConfigInterface::class);
            $about = resolve(AboutInterface::class);
            $education = resolve(EducationInterface::class);
            $skill = resolve(SkillInterface::class);
            $experience = resolve(ExperienceInterface::class);
            $project = resolve(ProjectInterface::class);
            $service = resolve(ServiceInterface::class);
            $visitor = resolve(VisitorInterface::class);
            $message = resolve(MessageInterface::class);

            //portfolio config table seed

            //template
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__TEMPLATE,
                'setting_value' => 'rigel',
                'default_value' => 'rigel',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //accent color
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__ACCENT_COLOR,
                'setting_value' => '#1890ff',
                'default_value' => '#1890ff',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //google analytics ID
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__GOOGLE_ANALYTICS_ID,
                'setting_value' => Config::get('custom.demo_mode') ? 'G-PS8JF33VLD' : '',
                'default_value' => Config::get('custom.demo_mode') ? 'G-PS8JF33VLD' : '',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //maintenance mode
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__MAINTENANCE_MODE,
                'setting_value' => CoreConstants::FALSE,
                'default_value' => CoreConstants::FALSE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            //visibility
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_ABOUT,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_SKILL,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_EDUCATION,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_EXPERIENCE,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_PROJECT,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_SERVICE,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_CONTACT,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_FOOTER,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_CV,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__VISIBILITY_SKILL_PROFICIENCY,
                'setting_value' => CoreConstants::TRUE,
                'default_value' => CoreConstants::TRUE,
            ];
            $portfolioConfig->insertOrUpdate($data);

            //header script
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__SCRIPT_HEADER,
                'setting_value' => '',
                'default_value' => '',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //footer script
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__SCRIPT_FOOTER,
                'setting_value' => '',
                'default_value' => '',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //meta title
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__META_TITLE,
                'setting_value' => '',
                'default_value' => '',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //meta author
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__META_AUTHOR,
                'setting_value' => '',
                'default_value' => '',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //meta description
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__META_DESCRIPTION,
                'setting_value' => '',
                'default_value' => '',
            ];
            $portfolioConfig->insertOrUpdate($data);

            //meta image
            try {
                if (is_dir('public/assets/common/img/meta-image')) {
                    $dir = 'public/assets/common/img/meta-image';
                } else {
                    $dir = 'assets/common/img/meta-image';
                }
                $leave_files = array('.gitkeep');

                foreach (glob("$dir/*") as $file) {
                    if (!in_array(basename($file), $leave_files)) {
                        unlink($file);
                    }
                }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }
            $data = [
                'setting_key' => CoreConstants::PORTFOLIO_CONFIG__META_IMAGE,
                'setting_value' => '',
                'default_value' => '',
            ];
            $portfolioConfig->insertOrUpdate($data);


            //about table seed
            try {
                try {
                    //avatar
                    if (is_dir('public/assets/common/img/avatar')) {
                        $dir = 'public/assets/common/img/avatar';
                    } else {
                        $dir = 'assets/common/img/avatar';
                    }
                    $leave_files = array('.gitkeep');

                    foreach (glob("$dir/*") as $file) {
                        if (!in_array(basename($file), $leave_files)) {
                            unlink($file);
                        }
                    }

                    if (is_dir('public/assets/common/img/avatar')) {
                        copy('public/assets/common/default/avatar/default.png', $dir.'/default.png');
                    } else {
                        copy('assets/common/default/avatar/default.png', $dir.'/default.png');
                    }
                } catch (\Throwable $th) {
                    Log::error($th->getMessage());
                }

                try {
                    //cover
                    if (is_dir('public/assets/common/img/cover')) {
                        $dir = 'public/assets/common/img/cover';
                    } else {
                        $dir = 'assets/common/img/cover';
                    }
                    $leave_files = array('.gitkeep');

                    foreach (glob("$dir/*") as $file) {
                        if (!in_array(basename($file), $leave_files)) {
                            unlink($file);
                        }
                    }

                    if (is_dir('public/assets/common/img/cover')) {
                        copy('public/assets/common/default/cover/default.png', $dir.'/default.png');
                    } else {
                        copy('assets/common/default/cover/default.png', $dir.'/default.png');
                    }
                } catch (\Throwable $th) {
                    Log::error($th->getMessage());
                }

                try {
                    //cv
                    if (is_dir('public/assets/common/cv')) {
                        $dir = 'public/assets/common/cv';
                    } else {
                        $dir = 'assets/common/cv';
                    }

                    $leave_files = array('.gitkeep');

                    foreach (glob("$dir/*") as $file) {
                        if (!in_array(basename($file), $leave_files)) {
                            unlink($file);
                        }
                    }
                    if (is_dir('public/assets/common/default/cv/')) {
                        copy('public/assets/common/default/cv/default.pdf', $dir.'/default.pdf');
                    } else {
                        copy('assets/common/default/cv/default.pdf', $dir.'/default.pdf');
                    }
                } catch (\Throwable $th) {
                    Log::error($th->getMessage());
                }

                $data = [
                    'name' => 'Tyler Carter',
                    'email' => 'gtc198@gmail.com',
                    'avatar' => 'assets/common/img/avatar/old_photo.png',
                    'cover' => 'assets/common/img/cover/default.png',
                    'phone' => '18587316249',
                    'address' => '17430 Ambaum Blvd S., Burien, WA 98148',
                    'description' => 'I’m a data analyst and automation-focused developer based in Seattle. I help teams clean up data, automate reporting, and handle text-heavy workflows using Python, SQL, and practical AI tools. My work focuses on building systems that reduce repetitive work and are meant to be used in production.',
                    'taglines' => ["Data Analysis.", "Automation.", "Practical AI Support."],
                    'social_links' => [
                        [
                            'title' => 'LinkedIn',
                            'iconClass' => 'fab fa-linkedin-in',
                            'link' => 'https://www.linkedin.com/in/tyler-carter-info'
                        ],
                        [
                            'title' => 'Github',
                            'iconClass' => 'fab fa-github',
                            'link' => 'https://github.com/Tyler-Carter'
                        ],
                        [
                            'title' => 'Twitter',
                            'iconClass' => 'fab fa-twitter',
                            'link' => 'https://twitter.com'
                        ],
                        [
                            'title' => 'Mail',
                            'iconClass' => 'far fa-envelope',
                            'link' => 'mailto:gtc198@gmail.com'
                        ],
                    ],
                    'seederCV' => 'assets/common/cv/default.pdf',
                ];
                $about->store($data);

                //education table seed
                try {
                    $data = [
                        'institution' => 'Western Governor\'s University',
                        'period' => '2023-2027',
                        'degree' => 'Bachelor of Science',
                        'cgpa' => '4.00 out of 4.00',
                        'department' => 'Computer Science & Engineering',
                        'thesis' => 'AI Engineering'
                    ];
                    $education->store($data);

                    $data = [
                        'institution' => 'Edgewood High School',
                        'period' => '2000-2004',
                        'degree' => null,
                        'cgpa' => null,
                        'department' => null,
                        'thesis' => null
                    ];
                    $education->store($data);
                } catch (\Throwable $th) {
                    Log::error($th->getMessage());
                }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            //skill table seed
            try {
                $data = [
                    'name' => 'Python',
                    'proficiency' => '100'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'Java',
                    'proficiency' => '100'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'TypeScript',
                    'proficiency' => '100'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'JavaScript',
                    'proficiency' => '100'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'C++',
                    'proficiency' => '95'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'LangSmith',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'Docker',
                    'proficiency' => '95'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'SQL',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'Node.js',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'MySQL',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'PyTorch',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'TensorFlow & Keras',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'Scikit-learn',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'Hugging Face',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'n8n',
                    'proficiency' => '90'
                ];
                $skill->store($data);

                $data = [
                    'name' => 'CrewAI',
                    'proficiency' => '85'
                ];
                $skill->store($data);

            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            //experience table seed
            try {
                $data = [
                    'company' => 'Mobile Integration WorkGroup, Inc',
                    'period' => '2022-2024',
                    'position' => 'Technical Project Manager',
                    'details' => 'Analyzed operational implementation for Database Vault and drove data-backed
                                  process improvements, resulting in 50% less manual effort.

                                  Created Python/SQL-based KPI reporting dashboard for DB Vault project
                                  implementation used in sprint planning.

                                  Created the technical manuals of procedures for all operations regarding DB
                                  Vault.

                                  Created a Python script to track the contractual and maintenance costs of DB
                                  Vault reducing the manual effort required by 75%.

                                  Directed cross-functional teams in the adoption of agile methodologies and
                                  usage of JIRA, integrating the efforts of over 50 professionals across 8 teams.'
                ];
                $experience->store($data);

                $data = [
                    'company' => 'Cloudix Inc.',
                    'period' => '2020-2022',
                    'position' => 'Operations Program Manager',
                    'details' => 'Worked cross-functionally with software development teams to scope and
                                  implement scalable data collection processes for unstructured data which
                                  eliminated manual data intake requirements.

                                  Built and implemented data analytics processes used to surface themes/
                                  trends for ISV partners which resulted in a 75% reduction in time required to
                                  analyze the data.

                                  Developed and implemented KPIs/measurable goals to gauge success for
                                  the ISV Insights program.

                                  Owned working with business stakeholders, sales teams, and software
                                  developers to customize data views based on end user personas.

                                  Built a semi-automated process to understand themes and trends being
                                  experienced by Microsoft ISV partners based on unstructured text data.

                                  Implemented partner outreach initiative to better understand Microsoft
                                  partner pain points.

                                  Subject Matter Expert and point of contact for external/internal teams to
                                  utilize for understanding the ISV (Independent Software Vendor) Connect
                                  program.'
                ];
                $experience->store($data);

                $data = [
                    'company' => 'Amazon',
                    'period' => '2018 - 2020',
                    'position' => 'Program Manager II',
                    'details' => 'Managed daily operations for Amazon Lockers resulting in 5x program
                                  growth in 2016.

                                  Facilitated end to end launches of over a thousand new Lockers deployed in
                                  2017 globally.

                                  Coordinated 6 stakeholder groups to improve the deployment workflow and
                                  automate tracking reports.

                                  Sole owner of triage and escalation management from customer service and
                                  business development teams.

                                  Owned relationship with Whole Foods business development and
                                  responsible for 8.64% of the yearly goal which exceeded my personal goal of
                                  5% and helped drive the team to successfully meeting our yearly goal.

                                  Built inputs for new financial models to identify expansions in existing sites
                                  and new geographical locations.

                                  Built requirements for technical operations reporting metrics for Leadership
                                  WBR.

                                  Reduced 3rd party vendor response time by 1 business day for customer
                                  power issues.

                                  Ensured governmental compliance of program’s Locker installations.

                                  Partnered with vendors and contractors to meet construction timelines and
                                  running installation operations.'
                ];
                $experience->store($data);

                $data = [
                    'company' => 'Amazon',
                    'period' => '2014 - 2018',
                    'position' => 'Program Manager',
                    'details' => 'Oversaw carrier performance for OnTrac, UPS, Lasership, USPS, and
                                  Amazon Logistics.

                                  Managed and resolved delivery defects for the Amazon Locker program.

                                  Defined operating procedures for carrier escalation resolutions.

                                  Built and managed metrics and reporting for leadership regarding carriers
                                  and customer service.'
                ];
                $experience->store($data);

            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            //project table seed
            try {
                try {
                    //images
                    if (is_dir('public/assets/common/img/projects')) {
                        $dir = 'public/assets/common/img/projects';
                    } else {
                        $dir = 'assets/common/img/projects';
                    }

                    $leave_files = array('.gitkeep');

                    foreach (glob("$dir/*") as $file) {
                        if (!in_array(basename($file), $leave_files)) {
                            unlink($file);
                        }
                    }
                } catch (\Throwable $th) {
                    Log::error($th->getMessage());
                }

                $data = [
                    'title' => 'RAG Issue Triage Copilot',
                    'categories' => ['personal'],
                    'link' => 'https://github.com/Chive7840/rag_issue_triage',
                    'details' => 'A data + automation pipeline that uses retrieval-augmented techniques to triage, classify, and act on large volumes of GitHub and Jira issue text.
                                  This project demonstrates how AI-assisted text analysis can be applied to real operational workflows. Which can reduce manual review while remaining
                                  transparent, repeatable, and human-approved.',
                    'seeder_thumbnail' => 'assets/common/img/projects/demo_project_1_1.png',
                    'seeder_images' => [
                        'assets/common/img/projects/demo_project_1_1.png',
                        'assets/common/img/projects/demo_project_1_2.png'
                    ]
                ];
                if (is_dir('public/assets/common/default/projects')) {
                    copy('public/assets/common/default/projects/demo_project_1_1.png', $dir.'/demo_project_1_1.png');
                    copy('public/assets/common/default/projects/demo_project_1_2.png', $dir.'/demo_project_1_2.png');
                } else {
                    copy('assets/common/default/projects/demo_project_1_1.png', $dir.'/demo_project_1_1.png');
                    copy('assets/common/default/projects/demo_project_1_2.png', $dir.'/demo_project_1_2.png');
                }

                $project->store($data);

                $data = [
                    'title' => 'Demo Project 2',
                    'categories' => ['professional'],
                    'link' => 'https://www.facebook.com',
                    'details' => '',
                    'seeder_thumbnail' => 'assets/common/img/projects/demo_project_2_1.png',
                    'seeder_images' => [
                        'assets/common/img/projects/demo_project_2_1.png',
                        'assets/common/img/projects/demo_project_2_2.png'
                    ]
                ];

                if (is_dir('public/assets/common/default/projects')) {
                    copy('public/assets/common/default/projects/demo_project_2_1.png', $dir.'/demo_project_2_1.png');
                    copy('public/assets/common/default/projects/demo_project_2_2.png', $dir.'/demo_project_2_2.png');
                } else {
                    copy('assets/common/default/projects/demo_project_2_1.png', $dir.'/demo_project_2_1.png');
                    copy('assets/common/default/projects/demo_project_2_2.png', $dir.'/demo_project_2_2.png');
                }

                $project->store($data);

                $data = [
                    'title' => 'Demo Project 3',
                    'categories' => ['personal'],
                    'link' => 'https://www.linkedin.com',
                    'details' => '',
                    'seeder_thumbnail' => 'assets/common/img/projects/demo_project_3_1.png',
                    'seeder_images' => [
                        'assets/common/img/projects/demo_project_3_1.png',
                        'assets/common/img/projects/demo_project_3_2.png'
                    ]
                ];

                if (is_dir('public/assets/common/default/projects')) {
                    copy('public/assets/common/default/projects/demo_project_3_1.png', $dir.'/demo_project_3_1.png');
                    copy('public/assets/common/default/projects/demo_project_3_2.png', $dir.'/demo_project_3_2.png');
                } else {
                    copy('assets/common/default/projects/demo_project_3_1.png', $dir.'/demo_project_3_1.png');
                    copy('assets/common/default/projects/demo_project_3_2.png', $dir.'/demo_project_3_2.png');
                }

                $project->store($data);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            //service table seed
            try {
                $data = [
                    'title' => 'Full Stack Development',
                    'icon' => 'fas fa-code',
                    'details' => 'I develop full stack applications that move products from idea to production, covering UI, backend services, and data integration.
                    I prioritize practical engineering decisions, performance, and long-term maintainability over throwaway prototypes.'
                ];
                $service->store($data);

                $data = [
                    'title' => 'Data Analysis',
                    'icon' => 'fas fa-basketball-ball',
                    'details' => 'I build analytics systems that ingest, clean, and model data to produce repeatable, trustworthy insights.
                    This includes KPI definition, automated reporting, and analysis pipelines that reduce manual effort and improve decision velocity.'
                ];
                $service->store($data);

                $data = [
                    'title' => 'AI Integration/Automation',
                    'icon' => 'fas fa-shield-alt',
                    'details' => 'I build and deploy AI-powered automation for tasks such as text classification, triage, summarization, and workflow routing.
                    The focus is on reliable system integration, monitoring, and guardrails so AI features operate as dependable components of production systems.'
                ];
                $service->store($data);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            try {
                //visitor table seed
                foreach (range(1, 72) as $index) {
                    $data = [
                        'tracking_id' => null
                        'is_new' => null,
                        'ip' => null,
                        'is_desktop' => null,
                        'browser' => null,
                        'platform' => null,
                        'location' => null,
                        'created_at' => dateTimeThisMonth()->format('Y-m-d H:i:s'),
                    ];
                    $visitor->forceStore($data);
                }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            try {
                //message table seed
                foreach (range(1, 17) as $index) {
                    $data = [
                        'name' => null,
                        'email' => null,
                        'subject' => null,
                        'body' => null,
                        'replied' => null,
                        'created_at' => dateTimeThisMonth()->format('Y-m-d H:i:s'),
                    ];
                    $message->store($data);
                }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
