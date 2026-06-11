<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Blog;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        // Create categories
        $categories = [
            'Digital Marketing',
            'Social Media Strategy',
            'Content Creation',
            'Branding',
            'Analytics',
            'Creative Design',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Create sample blogs
        $blogData = [
            [
                'title' => 'The Power of Visual Storytelling',
                'short_description' => 'Discover how visual content transforms your digital marketing strategy and engages your audience.',
                'content' => '<p>Visual storytelling is one of the most powerful tools in modern marketing. It captures attention, evokes emotions, and communicates complex ideas in seconds.</p><p>In this comprehensive guide, we explore the psychology behind visual content, best practices for creating compelling visuals, and how to leverage platforms like Instagram, Pinterest, and TikTok to maximize engagement.</p><p>From photography to videography, infographics to animations, we cover all aspects of visual content creation that can elevate your brand presence.</p><p>Learn how successful brands use visual storytelling to differentiate themselves in a crowded marketplace and build lasting connections with their audience.</p>',
                'category_id' => 1,
                'image' => null,
            ],
            [
                'title' => 'Building an Authentic Social Media Presence',
                'short_description' => 'Learn how to create genuine connections with your audience through authentic social media engagement.',
                'content' => '<p>Authenticity is the foundation of successful social media marketing. In an era of fake followers and manufactured content, real engagement stands out.</p><p>This guide walks you through creating authentic content, engaging genuinely with your followers, and building a community around your brand values.</p><p>Discover strategies for transparent communication, handling negative feedback gracefully, and creating content that truly resonates with your target audience.</p><p>From startup founders to established enterprises, learn how authenticity can be your competitive advantage in the digital landscape.</p>',
                'category_id' => 2,
                'image' => null,
            ],
            [
                'title' => 'Content Calendar: Your Path to Consistency',
                'short_description' => 'Master content planning with strategic calendars that keep your brand voice consistent.',
                'content' => '<p>Consistency is key to building a strong online presence. A well-planned content calendar ensures your message reaches your audience regularly and predictably.</p><p>Learn how to develop a comprehensive content strategy, plan content themes for each month, and maintain flexibility for trending topics.</p><p>We explore tools for scheduling, templates for content planning, and best practices from top-performing brands across industries.</p><p>Whether you\'re managing one platform or ten, this guide provides actionable steps to streamline your content creation process.</p>',
                'category_id' => 3,
                'image' => null,
            ],
            [
                'title' => 'SEO Basics for Content Creators',
                'short_description' => 'Optimize your content for search engines without sacrificing quality or authenticity.',
                'content' => '<p>Search Engine Optimization (SEO) doesn\'t have to be complex. This beginner-friendly guide covers the fundamentals every content creator should know.</p><p>From keyword research to meta descriptions, internal linking to mobile optimization, we break down SEO into actionable steps.</p><p>Discover how to balance SEO best practices with creating content that genuinely serves your audience. Learn why technical SEO matters and how to work with developers if needed.</p><p>By the end of this guide, you\'ll have a solid foundation for optimizing your content to reach more people organically.</p>',
                'category_id' => 1,
                'image' => null,
            ],
            [
                'title' => 'Influencer Marketing: Partnership Strategies',
                'short_description' => 'Collaborate with influencers strategically to amplify your brand message.',
                'content' => '<p>Influencer marketing has evolved beyond sponsored posts. Today\'s successful campaigns involve genuine partnerships aligned with brand values.</p><p>This guide covers identifying the right influencers for your brand, negotiating partnerships, and measuring campaign success.</p><p>Learn about micro-influencers, nano-influencers, and macro-influencers - and when to use each strategy.</p><p>Explore real case studies of successful influencer campaigns and common mistakes to avoid in this rapidly evolving marketing channel.</p>',
                'category_id' => 2,
                'image' => null,
            ],
            [
                'title' => 'Video Marketing: Creating Content That Converts',
                'short_description' => 'Harness the power of video content to drive engagement and conversions.',
                'content' => '<p>Video is the fastest-growing content format. From YouTube to TikTok, Instagram Reels to LinkedIn videos, video content dominates digital spaces.</p><p>Learn how to create compelling video content with limited budgets, optimize videos for different platforms, and develop a video marketing strategy.</p><p>We cover everything from scripting and filming to editing and distribution, providing practical tips for creators at all skill levels.</p><p>Discover why video consistently outperforms other content types and how you can leverage this medium for your brand growth.</p>',
                'category_id' => 3,
                'image' => null,
            ],
        ];

        foreach ($blogData as $data) {
            Blog::create($data);
        }
    }
}
