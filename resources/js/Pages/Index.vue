<template>
    <nav class="main-nav">
        <div class="container">
            <div class="links">
                <div>
                    <InertiaLink :href="route('index')" :class="{ 'active': page.props.activeRoute === 'index' }">
                        <span>Index</span>
                    </InertiaLink>
                </div>
                <div class="ms-auto">
                    <template v-if="user">
                        <InertiaLink v-if="user.admin" :href="route('index')">
                            <span>Admin</span>
                        </InertiaLink>
                        <InertiaLink :href="route('auth.logout')" method="POST" as="button" class="link">
                            <span>Logout</span>
                        </InertiaLink>
                    </template>
                    <template v-else>
                        <a :href="route('auth.discord.redirect')" class="ms-auto">Login</a>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';
import User from '@/Contracts/User';
import route from 'ziggy-js';

const page = usePage();

const currentRoute: ComputedRef<string> = computed(() => page.props.activeRoute as string);

const user: ComputedRef<User | null> = computed(() => page.props.user as User | null);
</script>
