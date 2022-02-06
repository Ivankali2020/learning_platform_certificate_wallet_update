<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(rand(2,5));
        return [
            'name' => $name,
            'price' => rand(500,1500),
            'user_id' => User::all()->random()->id,
            'rating' => rand(1,5),
            'duration' => rand(1,4),
            'slug' => Str::slug($name),
            'description' =>  'Pure PHP နဲ့ MySQL ကို အသုံးပြုပြီးတော့ လက်တွေ့ Project တွေရေးသားပြီး လေ့ကျင့်ပေးသွားမည်ဖြစ်ပါတယ်။ PHP နဲ့ ပတ်သတ်တဲ့ security measurings တွေကိုပါ ထည့်သွင်း သင်ကြားပေးသွားမယ့်အပြင် MVC Framework တွေကို ချဉ်းကပ်နည်းကိုပါ သင်ကြားပေးပြီးတော့ Laravel framework ကို မိတ်ဆက်ပေးသွားမှာဖြစ်ပါတယ်။ ဘာတွေပါမလဲဆိုတဲ့ course outlines အသေးစိတ်ကိုတော့ သင်ရိုးများဆိုတဲ့ tab မှာကြည့်ရှုနိုင်ပါတယ်။',
            'category_id' => Category::all()->random()->id,
        ];
    }
}
