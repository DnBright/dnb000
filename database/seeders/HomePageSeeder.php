<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class HomePageSeeder extends Seeder
{
    public function run()
    {
        Page::updateOrCreate(['key' => 'home'], [
            'content' => [
                'hero_title' => 'Layanan Desain Grafis & Terlengkap',
                'hero_subtitle' => 'Temukan desainer terbaik untuk proyek Anda atau download template siap pakai dengan kualitas premium.',
                'cta1_label' => 'Mulai Proyek',
                'cta1_link' => '#',
                'cta2_label' => 'Jelajahi Template',
                'cta2_link' => '#',
                'projects_count' => '50K+',
                'designers_count' => '1K+',
                'satisfaction_percent' => '98%'
            ]
        ]);

        // default popular services
        Page::updateOrCreate(['key' => 'home'], [
            'content' => array_merge(
                Page::where('key','home')->first()->content ?? [],
                ['services' => [
                    ['title'=>'Desain Logo','subtitle'=>'Logo unik & profesional','image'=>'https://dummyimage.com/600x350/000/fff&text=Desain+Logo'],
                    ['title'=>'Design Stationery','subtitle'=>'Kartu nama, kop surat, & lainya','image'=>'https://dummyimage.com/600x350/f1fbe4/000&text=Stationery'],
                    ['title'=>'Website Design','subtitle'=>'UI/UX & landing page modern','image'=>'https://dummyimage.com/600x350/ddd/000&text=Website'],
                    ['title'=>'Kemasan Design','subtitle'=>'Packaging kreatif & menarik','image'=>'https://dummyimage.com/600x350/ffedcc/000&text=Kemasan'],
                    ['title'=>'Feeds Design','subtitle'=>'Feed Instagram & konten sosial','image'=>'https://dummyimage.com/600x350/ffe4f1/000&text=Feeds'],
                    ['title'=>'Design Lainnya','subtitle'=>'Banner, poster, & material lainnya','image'=>'https://dummyimage.com/600x350/eee/000&text=Lainnya'],
                ]]
            )
        ]);

        // default top designers
        Page::updateOrCreate(['key' => 'home'], [
            'content' => array_merge(
                Page::where('key','home')->first()->content ?? [],
                ['top_designers' => [
                    ['name'=>'Sarah Putri','role'=>'Logo & Brand Identity','image'=>'https://randomuser.me/api/portraits/women/44.jpg'],
                    ['name'=>'Andi Rahman','role'=>'UI/UX Designer','image'=>'https://randomuser.me/api/portraits/men/32.jpg'],
                    ['name'=>'Maya Sari','role'=>'Social Media Design','image'=>'https://randomuser.me/api/portraits/women/65.jpg'],
                    ['name'=>'Budi Santoso','role'=>'Print Design','image'=>'https://randomuser.me/api/portraits/men/12.jpg'],
                ]]
            )
        ]);

        // default templates
        Page::updateOrCreate(['key' => 'home'], [
            'content' => array_merge(
                Page::where('key','home')->first()->content ?? [],
                ['templates' => [
                    ['name'=>'Business Card Templates','price'=>'Rp 25K','image'=>'https://dummyimage.com/600x350/ddd/000&text=Business+Card','link'=>'#'],
                    ['name'=>'Instagram Story Pack','price'=>'Gratis','image'=>'https://dummyimage.com/600x350/eee/000&text=Story','link'=>'#'],
                    ['name'=>'Presentation Template','price'=>'Rp 75K','image'=>'https://dummyimage.com/600x350/ddd/000&text=Presentation','link'=>'#'],
                    ['name'=>'Brochure Template','price'=>'Rp 35K','image'=>'https://dummyimage.com/600x350/ccc/000&text=Brochure','link'=>'#'],
                ]]
            )
        ]);

        // default portfolio logos
        Page::updateOrCreate(['key' => 'portfolio'], [
            'content' => array_merge(
                Page::where('key','portfolio')->first()->content ?? [],
                ['logo' => [
                    ['title'=>'Brand Refresh','caption'=>'Logo redesign for a fintech startup','image'=>'https://dummyimage.com/600x350/000/fff&text=Logo+1','link'=>'#'],
                    ['title'=>'Badge & Mark','caption'=>'Compact logo variants for app icons','image'=>'https://dummyimage.com/600x350/111/fff&text=Logo+2','link'=>'#'],
                    ['title'=>'Wordmark','caption'=>'Clean typographic logo for corporate use','image'=>'https://dummyimage.com/600x350/222/fff&text=Logo+3','link'=>'#'],
                ], 'stationery' => [
                    ['title'=>'Stationery Set 1','caption'=>'Business card and letterhead','image'=>'https://dummyimage.com/600x350/f1fbe4/000&text=Stationery+1','link'=>'#'],
                    ['title'=>'Stationery Set 2','caption'=>'Branded envelopes and notepads','image'=>'https://dummyimage.com/600x350/f3f3f3/000&text=Stationery+2','link'=>'#'],
                    ['title'=>'Stationery Set 3','caption'=>'Complete collateral pack','image'=>'https://dummyimage.com/600x350/f6f6f6/000&text=Stationery+3','link'=>'#']
                ], 'website' => [
                    ['title'=>'Landing 1','caption'=>'Corporate landing','image'=>'https://dummyimage.com/600x350/ddd/000&text=Website+1','link'=>'#'],
                    ['title'=>'Landing 2','caption'=>'Product landing','image'=>'https://dummyimage.com/600x350/ccc/000&text=Website+2','link'=>'#'],
                    ['title'=>'Dashboard UI','caption'=>'Analytics dashboard','image'=>'https://dummyimage.com/600x350/bbb/000&text=Website+3','link'=>'#']
                ], 'packaging' => [
                    ['title'=>'Packaging 1','caption'=>'Eco-friendly packaging','image'=>'https://dummyimage.com/600x350/ffedcc/000&text=Packaging+1','link'=>'#'],
                    ['title'=>'Packaging 2','caption'=>'Luxury box concept','image'=>'https://dummyimage.com/600x350/ffe4cc/000&text=Packaging+2','link'=>'#'],
                    ['title'=>'Packaging 3','caption'=>'Flexible pouch designs','image'=>'https://dummyimage.com/600x350/ffdede/000&text=Packaging+3','link'=>'#']
                ], 'feeds' => [
                    ['title'=>'Feed Pack 1','caption'=>'Instagram templates','image'=>'https://dummyimage.com/600x350/ffe4f1/000&text=Feeds+1','link'=>'#'],
                    ['title'=>'Feed Pack 2','caption'=>'Carousel templates','image'=>'https://dummyimage.com/600x350/ffd4e4/000&text=Feeds+2','link'=>'#'],
                    ['title'=>'Feed Pack 3','caption'=>'Stories & highlight covers','image'=>'https://dummyimage.com/600x350/ffccdd/000&text=Feeds+3','link'=>'#']
                ], 'other' => [
                    ['title'=>'Poster 1','caption'=>'Event poster','image'=>'https://dummyimage.com/600x350/eee/000&text=Other+1','link'=>'#'],
                    ['title'=>'Banner 1','caption'=>'Web banner set','image'=>'https://dummyimage.com/600x350/ddd/000&text=Other+2','link'=>'#'],
                    ['title'=>'Flyer 1','caption'=>'Retail promotional flyer','image'=>'https://dummyimage.com/600x350/ccc/000&text=Other+3','link'=>'#']
                ]]
            )
        ]);

        Page::updateOrCreate(['key' => 'search'], [
            'content' => [
                'search_placeholder' => 'Cari jasa desain, template, atau desainer...',
                'intro_text' => 'Gunakan pencarian untuk menemukan layanan yang Anda butuhkan dengan cepat.',
                'featured_categories' => 'Logo,Poster,Feed IG,Thumbnail,UI Kit',
            ]
        ]);

        // default layanan (paket) - editable via admin/pages/layanan
        Page::updateOrCreate(['key' => 'layanan'], [
            'content' => [
                'services' => [
                    ['title'=>'Logo Design','subtitle'=>'Membuat logo profesional sesuai brand Anda','image'=>'https://dummyimage.com/600x350/000/fff&text=Logo','paket'=>'logo-design'],
                    ['title'=>'Desain Stationery','subtitle'=>'Kartu nama, kop surat, & kebutuhan kantor','image'=>'https://dummyimage.com/600x350/f1fbe4/000&text=Stationery','paket'=>'desain-stationery'],
                    ['title'=>'Website Design','subtitle'=>'UI/UX & landing page modern','image'=>'https://dummyimage.com/600x350/ddd/000&text=Website','paket'=>'website-design'],
                    ['title'=>'Kemasan Design','subtitle'=>'Packaging kreatif & menarik','image'=>'https://dummyimage.com/600x350/ffedcc/000&text=Packaging','paket'=>'kemasan-design'],
                    ['title'=>'Feed Design','subtitle'=>'Desain konten feed & sosial media','image'=>'https://dummyimage.com/600x350/ffe4f1/000&text=Feeds','paket'=>'feed-design'],
                    ['title'=>'Design Lainnya','subtitle'=>'Banner, poster, & material lainnya','image'=>'https://dummyimage.com/600x350/eee/000&text=Lainnya','paket'=>'design-lainnya'],
                ]
            ]
        ]);

        // default reviews/testimonials
        Page::updateOrCreate(['key' => 'home'], [
            'content' => array_merge(
                Page::where('key','home')->first()->content ?? [],
                ['reviews' => [
                        ['message'=>'Pelayanan sangat memuaskan! Desainer sangat memahami brief.','author'=>'Klien','rating'=>5],
                        ['message'=>'Template yang tersedia sangat berkualitas dan mudah diedit.','author'=>'Klien','rating'=>5],
                        ['message'=>'Proses pemesanan mudah, komunikasi lancar.','author'=>'Klien','rating'=>5],
                        ['message'=>'Desain selesai dengan cepat dan tepat waktu.','author'=>'Klien','rating'=>5],
                        ['message'=>'Harga terjangkau untuk kualitas premium.','author'=>'Klien','rating'=>5],
                        ['message'=>'Customer support responsif dan membantu.','author'=>'Klien','rating'=>5],
                ]]
            )
        ]);
    }
}
