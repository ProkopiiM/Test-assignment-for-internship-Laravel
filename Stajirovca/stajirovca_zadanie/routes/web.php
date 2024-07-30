<?php

use App\Http\Controllers\AdminDirectory\AdminController;
use App\Http\Controllers\AdminDirectory\ManagmentProductController;
use App\Http\Controllers\AuthDirectory\AuthUserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PasswordDirectory\ForgotPasswordController;
use App\Http\Controllers\PasswordDirectory\ResetPasswordController;
use App\Http\Controllers\UserDirectory\ProfileController;
use Illuminate\Support\Facades\Route;

/*для гостей*/
Route::middleware("guest")->middleware('')->group(function () {
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('password/email', 'index')->name('password.index');
        Route::post('password/email', 'store')->name('password.email');
    });
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('password/reset/{token}/{email}', 'index')->name('password.reset');
        Route::post('password/reset', 'store')->name('password.update');
    });
    Route::controller(\App\Http\Controllers\AuthDirectory\AuthUserController::class)->group(function () {
        Route::get('/login', 'index')->name('login.index');
        Route::post('/login', 'store')->name('login.store');
    });
});

/*главное меню*/
Route::controller(MainController::class)->group(function () {
   Route::get('/', 'index')->name('main.index');
});

/*поиск*/
Route::controller(\App\Http\Controllers\UserDirectory\SearchController::class)->group(function () {
    Route::get('/search', 'index')->name('search.index');
});

/*для продуктов*/
Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
    Route::get('/product', 'index')->name('product.index');
    Route::post('/product/store_review', [\App\Http\Controllers\ProductController::class, 'store_review'])->name('product.store_review');
});

/*корзина*/
Route::controller(\App\Http\Controllers\UserDirectory\BacketController::class)->group(function () {
    Route::get('/backet', 'index')->name('backet.index');
    Route::post('/backet', 'store')->name('backet.store');
    Route::post('/backet/clear', 'clear')->name('backet.clear');
    Route::post('/backet/edit', 'edit')->name('backet.edit');
});

/*заказы для пользователя*/
Route::controller(\App\Http\Controllers\UserDirectory\OrderController::class)->group(function () {
    Route::get('/order', 'index')->name('order.index');
    Route::post('/order', 'store')->name('order.store');
    Route::get('/order/success', function () {
        return view('UserDirectory.Order.final_order');
    })->name('order.success');
});

/*регистрация*/
Route::controller(\App\Http\Controllers\UserDirectory\RegistrationController::class)->group(function () {
   Route::get('/registration', 'index')->name('registration.index');
   Route::post('/registration', 'store')->name('registration.store');
});

/*профиль*/
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile.index');
    Route::get('/profile/user-data', 'user_data')->name('profile.user-data');
    Route::get('/profile/order-history', 'order_history')->name('profile.order-history');
    Route::put('/profile/save-data/', 'update')->name('profile.update');
});

/*категории*/
Route::controller(\App\Http\Controllers\UserDirectory\CategoryController::class)->group(function () {
    Route::get('/category', 'index')->name('category.index');
});

/*выход из профиля пользвоателя*/
Route::controller(AuthUserController::class)->group(function () {
   Route::get('/logout', 'logout')->name('logout.index');
});

/*карточки информации*/
Route::controller(\App\Http\Controllers\InformationController::class)->group(function () {
    Route::get('/information', 'index')->name('information.index');
});




/*авторизация для администратора*/
Route::controller(\App\Http\Controllers\AuthDirectory\AuthAdminController::class)->group(function () {
    Route::get('/admin-login', 'index')->name('admin.index');
    Route::post('/admin-login', 'store')->name('admin.store');
});

/*главная страница для авторизации*/
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin-panel', 'index')->name('admin-panel.index');
});

/*для работы с товарами*/ /*P.S прошу прощения за все в один контроллер, думал что создавать 4 штуки будет много*/
Route::middleware('auth:admin')->group(function () {
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentProductController::class)->group(function () {
        Route::get('/admin-panel/products', 'index')->name('managment-product.index');
        Route::get('/admin-panel/product', 'product_view')->name('managment-product.view');
        Route::post('/admin-panel/product', 'create')->name('managment-product.create');
        Route::put('/admin-panel/product-edit/', 'product_edit')->name('managment-product.update');
        Route::delete('/admin-panel/product-bond-delete/', 'bond_delete')->name('managment-product-bond.delete');
        Route::post('/admin-panel/product-bond-add/', 'bond_add')->name('managment-product-bond.add');
        Route::post('admin-panel/product-tech-add/', 'product_tech_attribute_add')->name('managment-product-tech.add');
        Route::delete('admin-panel/product-tech-delete/', 'product_tech_attribute_delete')->name('managment-product-tech.detele');
        Route::delete('admin-panel/product-image-delete/', 'product_image_delete')->name('managment-product-image.detele');
    });

    /*для работы с заказами*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentOrderController::class)->group(function () {
        Route::get('/admin-panel/orders','index')->name('admin-panel.orders.index');
        Route::put('/admin-panel/order-update', 'update')->name('admin-panel.orders.update');
    });

    /*для работы с пользователями*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentUserController::class)->group(function () {
        Route::get('/admin-panel/users', 'index')->name('admin-panel.users.index');
        Route::get('/admin-panel/user', 'create')->name('admin-panel.users.create');
        Route::delete('admin-panel/user-delete', 'destroy')->name('admin-panel.users.delete');
        Route::put('admin-panel/user-update', 'update')->name('admin-panel.users.update');
        Route::post('/admin-panel/user', 'store')->name('admin-panel.users.store');
    });

    /*для работы с компонентами*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentComponents\ManagmentComponentsController::class)->group(function () {
        Route::get('/admin-panel/components', 'index')->name('admin-panel.components.index');
        Route::get('/admin-panel/information', 'information')->name('admin-panel.information.index');
        Route::get('/admin-panel/categories', 'category')->name('admin-panel.category.index');
        Route::get('/admin-panel/review', 'review')->name('admin-panel.reviews.index');
        Route::get('/admin-panel/main-layout', 'main_layout')->name('admin-panel.main_layout');
        Route::get('/admin-panel/manufacturers', 'manufacturer')->name('admin-panel.manufacturers.index');
    });

    /*для работы с главным окном*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentComponents\ManagmentMainLayoutController::class)->group(function () {
        Route::delete('admin-panel/component/slider-delete', 'slider_destroy')->name('admin-panel.components.slider-destroy');
        Route::post('admin-panel/component/slider-add', 'slider_store')->name('admin-panel.components.slider-add');
        Route::delete('admin-panel/component/recommend-delete', 'recommend_destroy')->name('admin-panel.components.recommend-destroy');
        Route::post('admin-panel/component/recommend-add', 'recommend_store')->name('admin-panel.components.recommend-add');
    });

    /*для работы с информационными карточками*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentComponents\ManagmentInformationController::class)->group(function () {
        Route::get('/admin-panel/information/card', 'index')->name('admin-panel.information.information.index');
        Route::get('/admin-panel/information/card','create')->name('admin-panel.information.information.create');
        Route::put('/admin-panel/information/information-update', 'update')->name('admin-panel.information.information.update');
        Route::delete('admin-panel/information/information-delete', 'destroy')->name('admin-panel.information.information.destroy');
        Route::post('admin-panel/information/information-add', 'store')->name('admin-panel.information.information.add');
    });

    /*для работы с категориями и брендами*/ /*P.S опять прошу прощения скорее всего надо было разделить на бренды и категории*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentComponents\ManagmentCategoryController::class)->group(function () {
        Route::get('/admin-panel/categories/category', 'category_index')->name('admin-panel.categories.category.index');
        Route::get('/admin-panel/categories/category', 'category_create')->name('admin-panel.categories.category.create');
        Route::post('/admin-panel/categories/category','category_store')->name('admin-panel.categories.category.add');
        Route::delete('/admin-panel/categories/category-delete', 'category_destroy')->name('admin-panel.categories.category.destroy');
        Route::put('/admin-panel/categories/category-update', 'category_update')->name('admin-panel.categories.category.update');
        Route::get('/admin-panel/brands/brand', 'brand_index')->name('admin-panel.brands.brand.index');
        Route::get('/admin-panel/brands/brand', 'brand_create')->name('admin-panel.brands.brand.create');
        Route::post('/admin-panel/brands/brand','brand_store')->name('admin-panel.brands.brand.add');
        Route::delete('/admin-panel/brands/brand-delete', 'brand_destroy')->name('admin-panel.brands.brand.destroy');
        Route::put('/admin-panel/brands/brand-update', 'brand_update')->name('admin-panel.brands.brand.update');
    });

    /*для работы с отзывами*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentComponents\ManagmentReviewController::class)->group(function () {
        Route::get('/admin-panel/reviews', 'index')->name('admin-panel.reviews.review.index');
        Route::get('/admin-panel/review-update/{id}', 'update')->name('admin-panel.reviews.review.update');
    });

    /*для работы с производителями*/
    Route::controller(\App\Http\Controllers\AdminDirectory\ManagmentComponents\ManagmentManufacturerController::class)->group(function () {
        Route::get('/admin-panel/manufacturers/manufacturer/{id}', 'show')->name('admin-panel.manufacturers.manufacturer.show');
        Route::get('/admin-panel/manufacturers/manufacturer', 'create')->name('admin-panel.manufacturers.manufacturer.create');
        Route::put('/admin-panel/manufacturers/manufacturer-update/{id}', 'update')->name('admin-panel.manufacturers.manufacturer.update');
        Route::delete('/admin-panel/manufacturers/manufacturer-delete/{id}', 'destroy')->name('admin-panel.manufacturers.manufacturer.destroy');
        Route::post('admin-panel/manufacturers/manufacturer-add', 'store')->name('admin-panel.manufacturers.manufacturer.add');
    });
});

