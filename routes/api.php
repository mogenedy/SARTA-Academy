<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AboutHomeController;
use App\Http\Controllers\AboutInstituteController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CentralLabController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DirectorMessageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeCounterController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\NavBarController;
use App\Http\Controllers\PatentController;
use App\Http\Controllers\PatentCounterController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicationDataController;
use App\Http\Controllers\ResearcherProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('localization')->group(function () {
    
    Route::get('home' , [HomeController::class , 'index']);
    
    Route::group(["middleware" => "loggedIn"], function () {
    
        Route::get('user/profile' , [UserController::class , 'profile']);
        Route::get('subscription/index_admin', [SubscriptionController::class , 'index_admin']);
        Route::get('category/show_admin', [CategoryController::class , 'show_admin']);
        Route::get('home/global_search', [HomeController::class , 'global_search']);
        Route::post('groupRegistration/{uuid}', [SubscriptionController::class , 'store']);
        Route::apiResource('subscription', SubscriptionController::class);
        Route::apiResource('lesson', LessonController::class);
        
        Route::apiResource('user/researcherProfile', ResearcherProfileController::class , ['only' => ['store' , 'destroy']]);
        Route::post('user/researcherProfileByAdmin/{user}', [ResearcherProfileController::class , 'storeByAdmin']);

        Route::patch('user/update_profile', [UserController::class , 'update_profile']);
        Route::patch('researcher/swapResercher/{fResercher}/{sResercher}', [UserController::class , 'swapResercher']);

        Route::get('blog/recent_blogs', [BlogController::class , 'getRecentBlogs']);
        Route::get('blogTag/popular_tags', [BlogTagController::class , 'getPopularTags']);

        Route::apiResource('user', UserController::class);
        Route::apiResource('institute', InstituteController::class);
        Route::apiResource('course', CourseController::class);
        Route::apiResource('group', GroupController::class);
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('homeSlider', HomeSliderController::class);
        Route::apiResource('testimonial', TestimonialController::class);
        Route::apiResource('aboutHome', AboutHomeController::class);
        Route::apiResource('directorMessage', DirectorMessageController::class)->only('index' , 'update');
        Route::apiResource('homeCounter', HomeCounterController::class)->only('index' , 'update');
        Route::apiResource('event', EventController::class);
        Route::apiResource('blog', BlogController::class);
        Route::apiResource('blogCategory', BlogCategoryController::class);
        Route::apiResource('blogTag', BlogTagController::class);

        Route::apiResource('project', ProjectController::class);
        Route::apiResource('ticket', TicketController::class);
        Route::apiResource('ticket_type', TicketTypeController::class);
        Route::apiResource('contact', ContactController::class);
        Route::apiResource('magazine', MagazineController::class);
        Route::apiResource('calender', CalenderController::class);
        Route::apiResource('patent', PatentController::class);
        Route::apiResource('patentCounter', PatentCounterController::class)->only('index' , 'update');
        Route::apiResource('publication', PublicationController::class);
        Route::apiResource('publicationData', PublicationDataController::class)->only('index' , 'update' , 'show');
        Route::apiResource('prize', PrizeController::class);

        Route::apiResource('about', AboutController::class)->only('index' , 'update');

        Route::apiResource('aboutInstitute', AboutInstituteController::class)->except('index');
        Route::apiResource('department', DepartmentController::class);

        
        Route::apiResource('centralLabs', CentralLabController::class);
        Route::apiResource('gallery', GalleryController::class);
        Route::get('navBar', [NavBarController::class , 'index']);

        
        Route::get('user/ban_user/{user}', [UserController::class , 'ban_user']);
        Route::get('user/index_name', [UserController::class , 'index_name']);
        Route::post('user/assign_role/{user}', [UserController::class , 'assign_role']);
        Route::post('user/detach_institute/{user}', [UserController::class , 'detach_institute']);
    
        Route::get('group/main_group', [GroupController::class , 'main_group']);
        Route::get('private_group/{uuid}', [GroupController::class , 'show_by_link']);


    });

    
});





