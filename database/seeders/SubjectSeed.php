<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class SubjectSeed extends Seeder
{
    /** Heroicon component names assigned to each parent category. */
    private array $categoryIcons = [
        'Development'          => 'CodeBracketIcon',
        'Business'             => 'BriefcaseIcon',
        'Finance & Accounting' => 'BanknotesIcon',
        'IT & Software'        => 'ComputerDesktopIcon',
        'Office Productivity'  => 'DocumentTextIcon',
        'Personal Development' => 'LightBulbIcon',
        'Design'               => 'PaintBrushIcon',
        'Marketing'            => 'MegaphoneIcon',
        'Lifestyle'            => 'SparklesIcon',
        'Photography'          => 'CameraIcon',
        'Health & Fitness'     => 'HeartIcon',
        'Music'                => 'MusicalNoteIcon',
        'Teaching & Academics' => 'AcademicCapIcon',
    ];

    /** Icon pool used when picking randomly for child subjects. */
    private array $iconPool = [
        'BookOpenIcon', 'BeakerIcon', 'ChartBarIcon', 'CpuChipIcon',
        'GlobeAltIcon', 'RocketLaunchIcon', 'StarIcon', 'TrophyIcon',
        'PuzzlePieceIcon', 'FireIcon', 'WrenchScrewdriverIcon', 'KeyIcon',
        'SignalIcon', 'CircleStackIcon', 'CommandLineIcon', 'ShieldCheckIcon',
        'CloudIcon', 'TableCellsIcon', 'CalculatorIcon', 'FilmIcon',
        'LanguageIcon', 'ChatBubbleLeftRightIcon', 'CursorArrowRaysIcon',
        'SwatchIcon', 'MicrophoneIcon', 'TicketIcon', 'FlagIcon', 'TagIcon',
    ];

    private function generateImage(): string
    {
        $dir = storage_path('app/public/subjects');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Generate a simple colored SVG — no HTTP request, instant
        $colors  = ['4f46e5', '0891b2', '059669', 'd97706', 'dc2626', '7c3aed', 'db2777', '0284c7'];
        $bg      = $colors[array_rand($colors)];
        $filename = Str::uuid() . '.svg';
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">
  <rect width="400" height="300" fill="#{$bg}" opacity="0.15"/>
  <rect width="400" height="300" fill="none" stroke="#{$bg}" stroke-width="2" opacity="0.4"/>
</svg>
SVG;
        file_put_contents("{$dir}/{$filename}", $svg);

        return "subjects/{$filename}";
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate and reset primary key sequence (PostgreSQL)
        DB::statement('TRUNCATE TABLE subjects RESTART IDENTITY CASCADE');

        // Also clear old generated images
        Storage::disk('public')->deleteDirectory('subjects');

        $subjects = [
            'Development' => [
                "Web Development",
                "Data Science",
                "Mobile Apps",
                "Programming Languages",
                "Game Development",
                "Databases",
                "Software Testing",
                "Software Engineering",
                "Development Tools",
                "E-Commerce",
            ],
            "Business" => [
                "Finance",
                "Entrepreneurship",
                "Communications",
                "Management",
                "Sales",
                "Strategy",
                "Operations",
                "Project Management",
                "Business Law",
                "Data & Analytics",
                "Home Business",
                "Human Resources",
                "Industry",
                "Media",
                "Real Estate",
            ],
            "Finance & Accounting" => [
                "Accounting & Bookkeeping",
                "Compliance",
                "Cryptocurrency & Blockchain",
                "Economics",
                "Finance",
                "Finance Cert & Exam Prep",
                "Financial Modeling & Analysis",
                "Investing & Trading",
                "Money Management Tools",
                "Taxes",
                "Other Finance & Economics",
            ],
            "IT & Software" => [
                "IT Certification",
                "Network & Security",
                "Hardware",
                "Operating Systems",
                "Other",
            ],
            "Office Productivity" => [
                "Microsoft",
                "Apple",
                "Google",
                "SAP",
                "Oracle",
                "Other",
            ],
            "Personal Development" => [
                "Personal Transformation",
                "Productivity",
                "Leadership",
                "Personal Finance",
                "Career Development",
                "Parenting & Relationships",
                "Happiness",
                "Religion & Spirituality",
                "Personal Brand Building",
                "Creativity",
                "Influence",
                "Self Esteem",
                "Stress Management",
                "Memory & Study Skills",
                "Motivation",
                "Other",
            ],
            "Design" => [
                "Web Design",
                "Graphic Design",
                "Design Tools",
                "User Experience",
                "Game Design",
                "Design Thinking",
                "3D & Animation",
                "Fashion",
                "Architectural Design",
                "Interior Design",
                "Other",
            ],
            "Marketing" => [
                "Digital Marketing",
                "Search Engine Optimization",
                "Social Media Marketing",
                "Branding",
                "Marketing Fundamentals",
                "Analytics & Automation",
                "Public Relations",
                "Advertising",
                "Video & Mobile Marketing",
                "Content Marketing",
                "Growth Hacking",
                "Affiliate Marketing",
                "Product Marketing",
                "Other",
            ],
            "Lifestyle" => [
                "Arts & Crafts",
                "Food & Beverage",
                "Beauty & Makeup",
                "Travel",
                "Gaming",
                "Home Improvement",
                "Pet Care & Training",
                "Other",
            ],
            "Photography" => [
                "Digital Photography",
                "Photography Fundamentals",
                "Portraits",
                "Photography Tools",
                "Commercial Photography",
                "Video Design",
                "Other",
            ],
            "Health & Fitness" => [
                "Fitness",
                "General Health",
                "Sports",
                "Nutrition",
                "Yoga",
                "Mental Health",
                "Dieting",
                "Self Defense",
                "Safety & First Aid",
                "Dance",
                "Meditation",
                "Other",
            ],
            "Music" => [
                "Instruments",
                "Production",
                "Music Fundamentals",
                "Vocal",
                "Music Techniques",
                "Music Software",
                "Other",
            ],
            "Teaching & Academics" => [
                "Engineering",
                "Humanities",
                "Math",
                "Science",
                "Online Education",
                "Social Science",
                "Language",
                "Teacher Training",
                "Test Prep",
                "Other Teaching & Academics",
            ],

        ];


        foreach ($subjects as $key => $value) {
            $p = Subject::create([
                'title' => $key,
                'slug'  => Str::slug($key),
                'icon'  => $this->categoryIcons[$key] ?? $this->iconPool[array_rand($this->iconPool)],
                'image' => $this->generateImage(),
            ]);

            foreach ($value as $subject) {
                Subject::create([
                    'title'  => $subject,
                    'parent' => $p->id,
                    'slug'   => Str::slug($subject),
                    'icon'   => $this->iconPool[array_rand($this->iconPool)],
                    'image'  => $this->generateImage(),
                ]);
            }
        }
    }
}
