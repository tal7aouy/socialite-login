<template>
    <breeze-validation-errors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <div class="relative sm:max-w-sm w-full">
        <div
            class="
                card
                bg-blue-400
                shadow-lg
                w-full
                h-full
                rounded-3xl
                absolute
                transform
                -rotate-6
            "
        ></div>
        <div
            class="
                card
                bg-red-400
                shadow-lg
                w-full
                h-full
                rounded-3xl
                absolute
                transform
                rotate-6
            "
        ></div>
        <div
            class="relative w-full rounded-3xl px-6 py-4 bg-gray-100 shadow-md"
        >
            <label
                for=""
                class="
                    block
                    mt-3
                    text-sm text-gray-700 text-center
                    font-semibold
                "
            >
                Login
            </label>
            <form @submit.prevent="submit" class="mt-10">
                <div>
                    <breeze-input
                        id="email"
                        type="email"
                        placeholder="Email Address"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        class="
                            mt-1
                            block
                            w-full
                            border-none
                            bg-gray-100
                            h-11
                            rounded-xl
                            shadow-lg
                            hover:bg-blue-100
                            focus:bg-blue-100
                            focus:ring-0
                        "
                    />
                </div>

                <div class="mt-7">
                    <breeze-input
                        id="password"
                        type="password"
                        class="
                            mt-1
                            block
                            w-full
                            border-none
                            bg-gray-100
                            h-11
                            rounded-xl
                            shadow-lg
                            hover:bg-blue-100
                            focus:bg-blue-100
                            focus:ring-0
                        "
                        placeholder="Password"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                </div>

                <div class="mt-7 flex">
                    <label
                        for="remember_me"
                        class="inline-flex items-center w-full cursor-pointer"
                    >
                        <breeze-checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ml-2 text-sm text-gray-600"
                            >Remember me</span
                        >
                    </label>
                </div>

                <div class="mt-7">
                    <button
                        class="
                            bg-blue-500
                            w-full
                            py-3
                            rounded-xl
                            text-white
                            shadow-xl
                            hover:shadow-inner
                            focus:outline-none
                            transition
                            duration-500
                            ease-in-out
                            transform
                            hover:-translate-x
                            hover:scale-105
                        "
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Login
                    </button>
                </div>

                <div class="flex mt-7 items-center text-center">
                    <hr class="border-gray-300 border-1 w-full rounded-md" />
                    <label
                        class="block font-medium text-sm text-gray-600 w-full"
                    >
                        Login with
                    </label>
                    <hr class="border-gray-300 border-1 w-full rounded-md" />
                </div>

                <div class="flex mt-7 justify-between w-full">
                    <a
                        :href="route('login.facebook')"
                        class="
                            mr-5
                            bg-blue-500
                            border-none
                            px-2
                            py-2
                            rounded-xl
                            cursor-pointer
                            text-white
                            shadow-xl
                            hover:shadow-inner
                            transition
                            duration-500
                            ease-in-out
                            transform
                            hover:-translate-x
                            hover:scale-105
                        "
                    >
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>

                    <a
                        :href="route('login.google')"
                        class="
                            bg-red-500
                            border-none
                            px-2
                            py-2
                            rounded-xl
                            cursor-pointer
                            text-white
                            shadow-xl
                            hover:shadow-inner
                            transition
                            duration-500
                            ease-in-out
                            transform
                            hover:-translate-x
                            hover:scale-105
                        "
                    >
                        <i class="fab fa-google fa-2x"></i>
                    </a>
                    <a
                        :href="route('login.github')"
                        class="
                            mr-5
                            bg-indigo-500
                            border-none
                            px-2
                            py-2
                            rounded-xl
                            cursor-pointer
                            text-white
                            shadow-xl
                            hover:shadow-inner
                            transition
                            duration-500
                            ease-in-out
                            transform
                            hover:-translate-x
                            hover:scale-105
                        "
                    >
                        <i class="fab fa-github fa-2x"></i>
                    </a>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <inertia-link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="
                            underline
                            text-sm text-gray-600
                            hover:text-gray-900
                        "
                    >
                        Forgot your password?
                    </inertia-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import BreezeButton from "@/Components/Button";
import BreezeGuestLayout from "@/Layouts/Guest";
import BreezeInput from "@/Components/Input";
import BreezeCheckbox from "@/Components/Checkbox";
import BreezeLabel from "@/Components/Label";
import BreezeValidationErrors from "@/Components/ValidationErrors";

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeCheckbox,
        BreezeLabel,
        BreezeValidationErrors,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: false,
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("login"), {
                onFinish: () => this.form.reset("password"),
            });
        },
    },
};
</script>
