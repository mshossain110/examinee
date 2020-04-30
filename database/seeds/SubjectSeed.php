<?php

use App\Subject;
use Illuminate\Database\Seeder;

class SubjectSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
                "title" => $key,
                'slug' => \Str::slug($key)
            ]);

            foreach ($value as $subject) {
                Subject::create([
                    "title" => $subject,
                    'parent' => $p->id,
                    'slug' => \Str::slug($subject)
                ]);
            }
        }
        
    }
}
