<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function editHome()
    {
        $page = Page::firstOrCreate(['key'=>'home']);
        $content = $page->content ?? [];
        return view('admin.pages.home-edit', compact('content','page'));
    }

    public function editServices()
    {
        $page = Page::firstOrCreate(['key'=>'home']);
        $content = $page->content ?? [];
        return view('admin.pages.services-edit', compact('content','page'));
    }

    public function editSearch()
    {
        $page = Page::firstOrCreate(['key' => 'search']);
        $content = $page->content ?? [];
        return view('admin.pages.search-edit', compact('content','page'));
    }

    public function updateHome(Request $request)
    {
        $data = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1024',
            'cta1_label' => 'nullable|string|max:64',
            'cta1_link' => 'nullable|string|max:255',
            'cta2_label' => 'nullable|string|max:64',
            'cta2_link' => 'nullable|string|max:255',
            'projects_count' => 'nullable|string|max:32',
            'designers_count' => 'nullable|string|max:32',
            'satisfaction_percent' => 'nullable|string|max:8',
            'hero_image' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key'=>'home']);
        $content = $page->content ?? [];

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $path = $file->store('pages', 'public');
            // remove previous image if present
            $this->deletePhysicalFile($content['hero_image'] ?? null);
            // FIX: Force relative path for shared hosting compatibility
            $data['hero_image'] = '/storage/' . $path;
        } else {
            // Preserve existing image if no new one and not removing
            if (!$request->boolean('remove_hero_image') && !empty($content['hero_image'])) {
                $data['hero_image'] = $content['hero_image'];
            } else {
                $data['hero_image'] = null;
            }
        }

        // If hero_image explicitly set to null, remove the key entirely to keep content clean
        if (array_key_exists('hero_image', $data) && $data['hero_image'] === null) {
            unset($data['hero_image']);
            if (isset($content['hero_image'])) unset($content['hero_image']);
        }

        $page->content = array_merge($content, $data);
        $page->save();

        // Clear compiled views and application cache so changes appear immediately
        try {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
        } catch (\Exception $e) {
            // ignore failures clearing cache in some environments
        }

        return redirect()->route('admin.pages.home.edit')->with('success', 'Home page updated at '.now()->toDateTimeString());
    }

    public function updateServices(Request $request)
    {
        $data = $request->validate([
            'service_titles' => 'nullable|array',
            'service_titles.*' => 'nullable|string|max:255',
            'service_subtitles' => 'nullable|array',
            'service_subtitles.*' => 'nullable|string|max:255',
            'service_descriptions' => 'nullable|array',
            'service_descriptions.*' => 'nullable|string|max:1024',
            'service_images.*' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key'=>'home']);
        $existingContent = $page->content ?? [];
        $existingServices = $existingContent['services'] ?? [];

        $services = [];
        for ($i = 0; $i < 6; $i++) {
            $title = $data['service_titles'][$i] ?? null;
            $subtitle = $data['service_subtitles'][$i] ?? null;
            $description = $data['service_descriptions'][$i] ?? null;
            
            // Skip empty slots if they weren't there before
            if (!$title && !$subtitle && !$description && empty($existingServices[$i])) continue;

            $item = [
                'title' => $title,
                'subtitle' => $subtitle,
                'description' => $description,
            ];

            // Ensure each service has a paket slug
            if (!empty($existingServices[$i]['paket'])) {
                $item['paket'] = $existingServices[$i]['paket'];
            } elseif ($title) {
                $item['paket'] = Str::slug($title);
            } else {
                $item['paket'] = 'service-'.($i+1);
            }

            // Image Persistence Logic
            $imageField = "service_images.$i";
            if ($request->hasFile("service_images.$i")) {
                $file = $request->file("service_images")[$i];
                $path = $file->store('pages', 'public');
                $item['image'] = Storage::url($path);
                
                // Remove old image
                if (!empty($existingServices[$i]['image'])) {
                    $this->deletePhysicalFile($existingServices[$i]['image']);
                }
            } elseif ($request->input('remove_service_'.$i) == '1') {
                if (!empty($existingServices[$i]['image'])) {
                    $this->deletePhysicalFile($existingServices[$i]['image']);
                }
                $item['image'] = null;
            } elseif (!empty($existingServices[$i]['image'])) {
                $item['image'] = $existingServices[$i]['image'];
            } else {
                $item['image'] = null;
            }

            $services[] = $item;
        }

        $existingContent['services'] = $services;
        $page->content = $existingContent;
        $page->save();

        try { Artisan::call('view:clear'); Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->route('admin.pages.services.edit')->with('success', 'Services updated at '.now()->toDateTimeString());
    }

    protected function deletePhysicalFile($url)
    {
        if (empty($url)) return;
        $path = parse_url($url, PHP_URL_PATH);
        $path = preg_replace('#^/?storage/#', '', $path);
        $path = ltrim($path, '/');
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $full = storage_path('app/public/'.$path);
            if (file_exists($full)) @unlink($full);
        }
    }

    public function editTopDesigners()
    {
        $page = Page::firstOrCreate(['key'=>'home']);
        $content = $page->content ?? [];
        return view('admin.pages.top-designers-edit', compact('content','page'));
    }

    public function updateTopDesigners(Request $request)
    {
        $data = $request->validate([
            'designer_names' => 'nullable|array',
            'designer_names.*' => 'nullable|string|max:255',
            'designer_roles' => 'nullable|array',
            'designer_roles.*' => 'nullable|string|max:255',
            'designer_images.*' => 'nullable|image|max:2048',
            'designer_descriptions' => 'nullable|array',
            'designer_descriptions.*' => 'nullable|string|max:2000',
            'designer_links' => 'nullable|array',
            'designer_links.*' => 'nullable|string|max:255',
        ]);

        $page = Page::firstOrCreate(['key'=>'home']);
        $existingContent = $page->content ?? [];
        $existingDesigners = $existingContent['top_designers'] ?? [];

        $designers = [];
        for ($i=0;$i<4;$i++) {
            $name = $data['designer_names'][$i] ?? null;
            $role = $data['designer_roles'][$i] ?? null;
            $description = $data['designer_descriptions'][$i] ?? null;
            $link = $data['designer_links'][$i] ?? null;
            
            if (!$name && !$role && !$description && empty($existingDesigners[$i])) continue;

            $item = [
                'name' => $name,
                'role' => $role,
                'description' => $description,
                'link' => $link,
            ];

            if ($request->hasFile("designer_images.$i")) {
                $file = $request->file("designer_images")[$i];
                $path = $file->store('pages', 'public');
                $item['image'] = Storage::url($path);
                
                if (!empty($existingDesigners[$i]['image'])) {
                    $this->deletePhysicalFile($existingDesigners[$i]['image']);
                }
            } elseif ($request->input('remove_designer_'.$i) == '1') {
                if (!empty($existingDesigners[$i]['image'])) {
                    $this->deletePhysicalFile($existingDesigners[$i]['image']);
                }
                $item['image'] = null;
            } elseif (!empty($existingDesigners[$i]['image'])) {
                $item['image'] = $existingDesigners[$i]['image'];
            } else {
                $item['image'] = null;
            }

            $designers[] = $item;
        }

        $existingContent['top_designers'] = $designers;
        $page->content = $existingContent;
        $page->save();

        try { Artisan::call('view:clear'); Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->route('admin.pages.top_designers.edit')->with('success', 'Top designers updated at '.now()->toDateTimeString());
    }

    public function editTemplates()
    {
        $page = Page::firstOrCreate(['key'=>'home']);
        $content = $page->content ?? [];
        return view('admin.pages.templates-edit', compact('content','page'));
    }

    public function updateTemplates(Request $request)
    {
        $data = $request->validate([
            'template_names' => 'nullable|array',
            'template_names.*' => 'nullable|string|max:255',
            'template_prices' => 'nullable|array',
            'template_prices.*' => 'nullable|string|max:64',
            'template_links' => 'nullable|array',
            'template_links.*' => 'nullable|string|max:255',
            'template_images.*' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key'=>'home']);
        $existingContent = $page->content ?? [];
        $existingTemplates = $existingContent['templates'] ?? [];

        $templates = [];
        for ($i=0;$i<4;$i++) {
            $name = $data['template_names'][$i] ?? null;
            $price = $data['template_prices'][$i] ?? null;
            $link = $data['template_links'][$i] ?? null;
            
            if (!$name && !$price && !$link && empty($existingTemplates[$i])) continue;

            $item = [
                'name' => $name,
                'price' => $price,
                'link' => $link,
            ];

            if ($request->hasFile("template_images.$i")) {
                $file = $request->file("template_images")[$i];
                $path = $file->store('pages', 'public');
                $item['image'] = Storage::url($path);
                
                if (!empty($existingTemplates[$i]['image'])) {
                    $this->deletePhysicalFile($existingTemplates[$i]['image']);
                }
            } elseif ($request->input('remove_template_'.$i) == '1') {
                if (!empty($existingTemplates[$i]['image'])) {
                    $this->deletePhysicalFile($existingTemplates[$i]['image']);
                }
                $item['image'] = null;
            } elseif (!empty($existingTemplates[$i]['image'])) {
                $item['image'] = $existingTemplates[$i]['image'];
            } else {
                $item['image'] = null;
            }

            $templates[] = $item;
        }

        $existingContent['templates'] = $templates;
        $page->content = $existingContent;
        $page->save();

        try { Artisan::call('view:clear'); Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->route('admin.pages.templates.edit')->with('success', 'Templates updated at '.now()->toDateTimeString());
    }

    public function editReview()
    {
        $page = Page::firstOrCreate(['key'=>'home']);
        $content = $page->content ?? [];
        return view('admin.pages.review-edit', compact('content','page'));
    }

    public function updateReview(Request $request)
    {
        $data = $request->validate([
            'review_messages' => 'nullable|array',
            'review_messages.*' => 'nullable|string|max:1024',
            'review_authors' => 'nullable|array',
            'review_authors.*' => 'nullable|string|max:255',
            'review_ratings' => 'nullable|array',
            'review_ratings.*' => 'nullable|integer|min:1|max:5',
            'review_images.*' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key'=>'home']);
        $existingContent = $page->content ?? [];
        $existingReviews = $existingContent['reviews'] ?? [];

        $reviews = [];
        for ($i=0;$i<6;$i++) {
            $msg = $data['review_messages'][$i] ?? null;
            $auth = $data['review_authors'][$i] ?? null;
            $rating = $data['review_ratings'][$i] ?? null;
            
            if (!$msg && !$auth && empty($existingReviews[$i])) continue;

            $item = [
                'message' => $msg,
                'author' => $auth,
                'rating' => $rating,
            ];

            if ($request->hasFile("review_images.$i")) {
                $file = $request->file("review_images")[$i];
                $path = $file->store('pages', 'public');
                $item['image'] = Storage::url($path);
                
                if (!empty($existingReviews[$i]['image'])) {
                    $this->deletePhysicalFile($existingReviews[$i]['image']);
                }
            } elseif ($request->input('remove_review_'.$i) == '1') {
                if (!empty($existingReviews[$i]['image'])) {
                    $this->deletePhysicalFile($existingReviews[$i]['image']);
                }
                $item['image'] = null;
            } elseif (!empty($existingReviews[$i]['image'])) {
                $item['image'] = $existingReviews[$i]['image'];
            } else {
                $item['image'] = null;
            }

            if (!empty($item['message'])) {
                $reviews[] = $item;
            }
        }

        $existingContent['reviews'] = $reviews;
        $page->content = $existingContent;
        $page->save();

        try { Artisan::call('view:clear'); Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->route('admin.pages.review.edit')->with('success', 'Reviews updated at '.now()->toDateTimeString());
    }

    public function editPortfolioLogo()
    {
        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $content = $page->content ?? [];
        return view('admin.pages.portfolio-logo-edit', compact('content','page'));
    }

    public function updatePortfolioLogo(Request $request)
    {
        $data = $request->validate([
            'logo_titles' => 'nullable|array',
            'logo_titles.*' => 'nullable|string|max:255',
            'logo_captions' => 'nullable|array',
            'logo_captions.*' => 'nullable|string|max:1024',
            'logo_descriptions' => 'nullable|array',
            'logo_descriptions.*' => 'nullable|string|max:2000',
            'logo_links' => 'nullable|array',
            'logo_links.*' => 'nullable|string|max:255',
            'logo_images.*' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $existing = $page->content['logo'] ?? [];

        $items = [];
        for ($i=0;$i<3;$i++) {
            $title = $data['logo_titles'][$i] ?? null;
            $caption = $data['logo_captions'][$i] ?? null;
            $description = $data['logo_descriptions'][$i] ?? null;
            $link = $data['logo_links'][$i] ?? null;
            $item = [];
            if ($title) $item['title'] = $title;
            if ($caption) $item['caption'] = $caption;
            if ($description) $item['description'] = $description;
            if ($link) $item['link'] = $link;

            if (!empty($existing[$i]['image']) && empty($request->file('logo_images')[$i]) && empty($request->input('remove_logo_'.$i))) {
                $item['image'] = $existing[$i]['image'];
            }

            if ($request->hasFile('logo_images') && isset($request->file('logo_images')[$i])) {
                $file = $request->file('logo_images')[$i];
                $path = $file->store('pages', 'public');
                $item['image'] = Storage::url($path);
                if (!empty($existing[$i]['image'])) {
                    $prev = parse_url($existing[$i]['image'], PHP_URL_PATH);
                    $prev = preg_replace('#^/?storage/#','',$prev);
                    $prev = ltrim($prev, '/');
                    if (Storage::disk('public')->exists($prev)) {
                        Storage::disk('public')->delete($prev);
                    }
                }
            }

            if ($request->input('remove_logo_'.$i) == '1') {
                if (!empty($existing[$i]['image'])) {
                    $prev = parse_url($existing[$i]['image'], PHP_URL_PATH);
                    $prev = preg_replace('#^/?storage/#','',$prev);
                    $prev = ltrim($prev, '/');
                    if (Storage::disk('public')->exists($prev)) {
                        Storage::disk('public')->delete($prev);
                    }
                }
                unset($item['image']);
            }

            $items[] = $item;
        }

        $page->content = array_merge($page->content ?? [], ['logo' => $items]);
        $page->save();

        try { \Artisan::call('view:clear'); \Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->route('admin.portfolio.logo.edit')->with('success', 'Logo portfolio updated at '.now()->toDateTimeString());
    }

    // Stationery
    public function editPortfolioStationery()
    {
        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $content = $page->content ?? [];
        return view('admin.pages.portfolio-stationery-edit', compact('content','page'));
    }

    public function updatePortfolioStationery(Request $request)
    {
        return $this->updateGenericPortfolioCategory($request, 'stationery');
    }

    // Website
    public function editPortfolioWebsite()
    {
        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $content = $page->content ?? [];
        return view('admin.pages.portfolio-website-edit', compact('content','page'));
    }

    public function updatePortfolioWebsite(Request $request)
    {
        return $this->updateGenericPortfolioCategory($request, 'website');
    }

    // Packaging
    public function editPortfolioPackaging()
    {
        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $content = $page->content ?? [];
        return view('admin.pages.portfolio-packaging-edit', compact('content','page'));
    }

    public function updatePortfolioPackaging(Request $request)
    {
        return $this->updateGenericPortfolioCategory($request, 'packaging');
    }

    // Feeds
    public function editPortfolioFeeds()
    {
        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $content = $page->content ?? [];
        return view('admin.pages.portfolio-feeds-edit', compact('content','page'));
    }

    public function updatePortfolioFeeds(Request $request)
    {
        return $this->updateGenericPortfolioCategory($request, 'feeds');
    }

    // Other
    public function editPortfolioOther()
    {
        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $content = $page->content ?? [];
        return view('admin.pages.portfolio-other-edit', compact('content','page'));
    }

    public function updatePortfolioOther(Request $request)
    {
        return $this->updateGenericPortfolioCategory($request, 'other');
    }

    // Generic handler used by portfolio categories
    protected function updateGenericPortfolioCategory(Request $request, $category)
    {
        $data = $request->validate([
            $category.'_titles' => 'nullable|array',
            $category.'_titles.*' => 'nullable|string|max:255',
            $category.'_captions' => 'nullable|array',
            $category.'_captions.*' => 'nullable|string|max:1024',
            $category.'_descriptions' => 'nullable|array',
            $category.'_descriptions.*' => 'nullable|string|max:2000',
            $category.'_links' => 'nullable|array',
            $category.'_links.*' => 'nullable|string|max:255',
            $category.'_images.*' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key' => 'portfolio']);
        $existing = $page->content[$category] ?? [];

        $items = [];
        for ($i=0;$i<3;$i++) {
            $title = $data[$category.'_titles'][$i] ?? null;
            $caption = $data[$category.'_captions'][$i] ?? null;
            $description = $data[$category.'_descriptions'][$i] ?? null;
            $link = $data[$category.'_links'][$i] ?? null;
            $item = [];
            if ($title) $item['title'] = $title;
            if ($caption) $item['caption'] = $caption;
            if ($description) $item['description'] = $description;
            if ($link) $item['link'] = $link;

            if (!empty($existing[$i]['image']) && empty($request->file($category.'_images')[$i]) && empty($request->input('remove_'.$category.'_'.$i))) {
                $item['image'] = $existing[$i]['image'];
            }

            if ($request->hasFile($category.'_images') && isset($request->file($category.'_images')[$i])) {
                $file = $request->file($category.'_images')[$i];
                $path = $file->store('pages', 'public');
                $item['image'] = Storage::url($path);
                if (!empty($existing[$i]['image'])) {
                    $prev = parse_url($existing[$i]['image'], PHP_URL_PATH);
                    $prev = preg_replace('#^/?storage/#','',$prev);
                    $prev = ltrim($prev, '/');
                    if (Storage::disk('public')->exists($prev)) {
                        Storage::disk('public')->delete($prev);
                    }
                }
            }

            if ($request->input('remove_'.$category.'_'.$i) == '1') {
                if (!empty($existing[$i]['image'])) {
                    $prev = parse_url($existing[$i]['image'], PHP_URL_PATH);
                    $prev = preg_replace('#^/?storage/#','',$prev);
                    $prev = ltrim($prev, '/');
                    if (Storage::disk('public')->exists($prev)) {
                        Storage::disk('public')->delete($prev);
                    }
                }
                unset($item['image']);
            }

            $items[] = $item;
        }

        $page->content = array_merge($page->content ?? [], [$category => $items]);
        $page->save();

        try { \Artisan::call('view:clear'); \Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->back()->with('success', ucfirst($category).' portfolio updated at '.now()->toDateTimeString());
    }

    public function updateSearch(Request $request)
    {
        $data = $request->validate([
            'search_placeholder' => 'required|string|max:255',
            'intro_text' => 'nullable|string|max:1024',
            'featured_categories' => 'nullable|string|max:1024',
            'featured_titles' => 'nullable|array',
            'featured_titles.*' => 'nullable|string|max:255',
            'featured_images.*' => 'nullable|image|max:2048',
            'hero_image' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key'=>'search']);
        $existingContent = $page->content ?? [];
        $updateData = [
            'search_placeholder' => $data['search_placeholder'],
            'intro_text' => $data['intro_text'] ?? null,
            'featured_categories' => $data['featured_categories'] ?? null,
        ];

        // Handle hero image
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $path = $file->store('pages', 'public');
            $this->deletePhysicalFile($existingContent['hero_image'] ?? null);
            $updateData['hero_image'] = Storage::url($path);
        } elseif ($request->boolean('remove_hero_image')) {
            $this->deletePhysicalFile($existingContent['hero_image'] ?? null);
            $updateData['hero_image'] = null;
        } elseif (!empty($existingContent['hero_image'])) {
            $updateData['hero_image'] = $existingContent['hero_image'];
        }

        // Handle featured items
        $existingFeatured = $existingContent['featured_items'] ?? [];
        $newFeatured = [];
        if (!empty($data['featured_titles'])) {
            foreach ($data['featured_titles'] as $i => $title) {
                if (empty($title) && empty($existingFeatured[$i])) continue;

                $item = ['title' => $title];

                if ($request->hasFile("featured_images.$i")) {
                    $file = $request->file("featured_images")[$i];
                    $path = $file->store('pages', 'public');
                    $item['image'] = Storage::url($path);
                    if (!empty($existingFeatured[$i]['image'])) {
                        $this->deletePhysicalFile($existingFeatured[$i]['image']);
                    }
                } elseif ($request->input('remove_featured_'.$i) == '1') {
                    if (!empty($existingFeatured[$i]['image'])) {
                        $this->deletePhysicalFile($existingFeatured[$i]['image']);
                    }
                    $item['image'] = null;
                } elseif (!empty($existingFeatured[$i]['image'])) {
                    $item['image'] = $existingFeatured[$i]['image'];
                } else {
                    $item['image'] = null;
                }

                $newFeatured[] = $item;
            }
        }
        $updateData['featured_items'] = $newFeatured;

        $page->content = $updateData;
        $page->save();

        try { Artisan::call('view:clear'); Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->route('admin.pages.search.edit')->with('success', 'Search page updated at '.now()->toDateTimeString());
    }

    public function editLayanan()
    {
        $page = Page::firstOrCreate(['key' => 'layanan']);
        $content = $page->content ?? [];
        return view('admin.pages.layanan-edit', compact('content','page'));
    }

    public function updateLayanan(Request $request)
    {
        $data = $request->validate([
            // hero fields
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1024',
            'cta1_label' => 'nullable|string|max:64',
            'cta1_link' => 'nullable|string|max:255',
            'cta2_label' => 'nullable|string|max:64',
            'cta2_link' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|max:2048',

            // layanan items
            'layanan_titles' => 'nullable|array',
            'layanan_titles.*' => 'nullable|string|max:255',
            'layanan_pakets' => 'nullable|array',
            'layanan_pakets.*' => 'nullable|string|max:255',
            'layanan_subtitles' => 'nullable|array',
            'layanan_subtitles.*' => 'nullable|string|max:255',
            'layanan_prices' => 'nullable|array',
            'layanan_prices.*' => 'nullable|numeric|min:0',
            'layanan_images.*' => 'nullable|image|max:2048',
        ]);

        $page = Page::firstOrCreate(['key' => 'layanan']);
        $existing = $page->content['services'] ?? [];

        // Handle hero image upload similar to updateHome
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $path = $file->store('pages', 'public');
            if (!empty($page->content['hero_image'] ?? null)) {
                $prev = parse_url($page->content['hero_image'], PHP_URL_PATH);
                $prev = preg_replace('#^/?storage/#','',$prev);
                $prev = ltrim($prev, '/');
                if (Storage::disk('public')->exists($prev)) {
                    Storage::disk('public')->delete($prev);
                }
            }
            $data['hero_image'] = Storage::url($path);
        }

        if ($request->boolean('remove_hero_image')) {
            if (!empty($page->content['hero_image'] ?? null)) {
                $prev = parse_url($page->content['hero_image'], PHP_URL_PATH);
                $prev = preg_replace('#^/?storage/#','',$prev);
                $prev = ltrim($prev, '/');
                if (Storage::disk('public')->exists($prev)) {
                    Storage::disk('public')->delete($prev);
                }
            }
            $data['hero_image'] = null;
        }

        $services = [];
        for ($i = 0; $i < 6; $i++) {
            $title = $data['layanan_titles'][$i] ?? null;
            $subtitle = $data['layanan_subtitles'][$i] ?? null;
            $item = [];
            if ($title) $item['title'] = $title;
            if ($subtitle) $item['subtitle'] = $subtitle;

            // prefer posted paket, then existing, then slug of title
            if (!empty($data['layanan_pakets'][$i])) {
                $item['paket'] = $data['layanan_pakets'][$i];
            } elseif (!empty($existing[$i]['paket'])) {
                $item['paket'] = $existing[$i]['paket'];
            } elseif (!empty($title)) {
                $item['paket'] = Str::slug($title);
            }

            $currentPrice = $data['layanan_prices'][$i] ?? 0;
            $item['price'] = $currentPrice;

            // SYNC with designpackage table
            if (!empty($item['paket'])) {
                $pkg = \App\Models\DesignPackage::where('category', $item['paket'])->first();
                if ($pkg) {
                    $pkg->update(['price' => $currentPrice]);
                }
            }

            if (!empty($existing[$i]['image']) && empty($request->file('layanan_images')[$i]) && empty($request->input('remove_layanan_'.$i))) {
                $item['image'] = $existing[$i]['image'];
            }


            if ($request->hasFile('layanan_images') && isset($request->file('layanan_images')[$i])) {
                $file = $request->file('layanan_images')[$i];
                $path = $file->store('pages', 'public');
                $item['image'] = Storage::url($path);
                if (!empty($existing[$i]['image'])) {
                    $prev = parse_url($existing[$i]['image'], PHP_URL_PATH);
                    $prev = preg_replace('#^/?storage/#','',$prev);
                    $prev = ltrim($prev, '/');
                    if (Storage::disk('public')->exists($prev)) {
                        Storage::disk('public')->delete($prev);
                    }
                }
            }

            if ($request->input('remove_layanan_'.$i) == '1') {
                if (!empty($existing[$i]['image'])) {
                    $prev = parse_url($existing[$i]['image'], PHP_URL_PATH);
                    $prev = preg_replace('#^/?storage/#','',$prev);
                    $prev = ltrim($prev, '/');
                    if (Storage::disk('public')->exists($prev)) {
                        Storage::disk('public')->delete($prev);
                    }
                }
                unset($item['image']);
            }

            $services[] = $item;
        }

        // Build content array locally to avoid indirect modification on the Eloquent attribute
        $content = $page->content ?? [];
        $content['services'] = $services;

        // merge hero related content as top-level keys for backward compatibility
        $heroKeys = ['hero_title','hero_subtitle','cta1_label','cta1_link','cta2_label','cta2_link','hero_image'];
        foreach ($heroKeys as $k) {
            if (array_key_exists($k, $data)) {
                // if explicitly set to null (eg. removed image) keep null so update logic can unset later
                $content[$k] = $data[$k];
            }
        }

        // Assign back and save
        $page->content = $content;
        $page->save();

        try { Artisan::call('view:clear'); Artisan::call('cache:clear'); } catch (\Exception $e) {}

        return redirect()->route('admin.pages.layanan.edit')->with('success', 'Layanan updated at '.now()->toDateTimeString());
    }

    public function sync()
    {
        try {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return redirect()->back()->with('success', 'System synchronized successfully. All interfaces updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Synchronization failed: ' . $e->getMessage());
        }
    }
}
