<template>
    <div>
        <div :class="darkMode ? 'darkMode' : ''" id="main-wrapper">
            <!-- Menu -->
            <nav
                v-if="
                    $route.path != '/login' &&
                        $route.path != '/register' &&
                        $route.path != '/resetPassword' &&
                        $route.path != '/forgetPassword'
                "
                :class="
                    sidebar
                        ? '_navbar _fixed_top _navbar_light _navbar_wap _mini_navbar'
                        : '_navbar _fixed_top _navbar_light _navbar_wap'
                "
            >
                <div class="_navbar_left">
                    <div class="_navbar_logo">
                        <h3>TimeSheet App</h3>
                    </div>

                    <!-- TOP BAR -->
                    <div class="_navbar_left_button">
                        <div
                            @click="sidebar = !sidebar"
                            class="_navbar_left_icon"
                        >
                            <Icon type="md-list" />
                        </div>

                        <div
                            @click="mobSidebar = !mobSidebar"
                            class="_navbar_left_icon _mob_icon"
                        >
                            <Icon type="md-list" />
                        </div>
                    </div>

                    <div class="_navbar_search">
                        <div class="_navbar_search_main_all">
                            <div class="_navbar_search_main">
                                <Icon type="ios-search-outline" />
                                <input type="text" placeholder="Search.." />
                                <div class="outline"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TOP BAR RIGHT -->
                <div class="_navbar_right">
                    <ul class="_navbar_right_list">
                        <li class="_mosearch" @click="mobSearchOpen = true">
                            <Icon type="ios-search-outline" />
                        </li>

                        <!-- NOTIFICATIONS AND MESSAGES ON THE TOP BAR RIGHT -->
                        <div class="_navbar_right">
                            <ul class="_navbar_right_list">
                                <li
                                    class="_mosearch d-none"
                                    @click="mobSearchOpen = true"
                                >
                                    <Icon type="ios-search-outline" />
                                </li>
                                <adminNotification />

                                <li class="_nav_pro d-none">
                                    <Dropdown
                                        trigger="click"
                                        placement="bottom-end"
                                    >
                                        <a href="javascript:void(0)">
                                            <div class="_nav_pro_pic">
                                                <img
                                                    class="_nav_pro_img"
                                                    src="/static/img/photo.jpg"
                                                    alt=""
                                                    title=""
                                                />
                                            </div>
                                        </a>
                                        <DropdownMenu slot="list">
                                            <div class="_nav_pro_main">
                                                <div class="_nav_pro_top">
                                                    <div
                                                        class="_nav_pro_top_pic"
                                                    >
                                                        <img
                                                            class="_nav_pro_top_img"
                                                            src="/static/img/ONE.jpg"
                                                            title=""
                                                            alt=""
                                                        />
                                                    </div>

                                                    <div
                                                        class="_nav_pro_top_details"
                                                    >
                                                        <p
                                                            class="_nav_pro_top_name"
                                                        >
                                                            Steave Jobs
                                                        </p>
                                                        <p
                                                            class="_nav_pro_top_email"
                                                        >
                                                            SteaveJobs@gmail.com
                                                        </p>
                                                    </div>
                                                </div>

                                                <div
                                                    class="_nav_pro_list_main _1border_color"
                                                >
                                                    <ul class="_nav_pro_list">
                                                        <li>
                                                            <router-link
                                                                to="/profile"
                                                            >
                                                                <Icon
                                                                    type="md-person"
                                                                />
                                                                <p
                                                                    class="_nav_pro_list_text"
                                                                >
                                                                    My Profile
                                                                </p>
                                                            </router-link>
                                                        </li>

                                                        <li>
                                                            <a href="">
                                                                <Icon
                                                                    type="md-cash"
                                                                />
                                                                <p
                                                                    class="_nav_pro_list_text"
                                                                >
                                                                    My Balance
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="">
                                                                <Icon
                                                                    type="md-mail"
                                                                />
                                                                <p
                                                                    class="_nav_pro_list_text"
                                                                >
                                                                    My Inbox
                                                                </p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div
                                                    class="_nav_pro_list_main _1border_color"
                                                >
                                                    <ul class="_nav_pro_list">
                                                        <li>
                                                            <a href="">
                                                                <Icon
                                                                    type="ios-cog"
                                                                />
                                                                <p
                                                                    class="_nav_pro_list_text"
                                                                >
                                                                    Account
                                                                    Setting
                                                                </p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div
                                                    class="_nav_pro_list_main _1border_color"
                                                >
                                                    <ul class="_nav_pro_list">
                                                        <li>
                                                            <a href="">
                                                                <Icon
                                                                    type="ios-exit"
                                                                />
                                                                <p
                                                                    class="_nav_pro_list_text"
                                                                >
                                                                    Log Out
                                                                </p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </DropdownMenu>
                                    </Dropdown>
                                </li>
                            </ul>
                        </div>

                        <!-- AVATAR WITH DROPDOWN -->
                    </ul>
                </div>

                <!-- Mobile Search -->
                <div
                    class="_mob_search"
                    :class="mobSearchOpen ? '_mob_search_open' : ''"
                >
                    <div class="_mob_search_main">
                        <div class="_navbar_search_main_all">
                            <div class="_navbar_search_main">
                                <Icon type="ios-search-outline" />
                                <input type="text" placeholder="Search.." />
                                <div class="outline"></div>
                            </div>
                        </div>
                    </div>
                    <div class="_mob_search_close">
                        <Icon @click="mobSearchOpen = false" type="md-close" />
                    </div>
                </div>
                <!-- Mobile Search -->
            </nav>
            <!-- Menu end -->

            <!-- Sidebar  -->
            <aside
                v-if="
                    $route.path != '/login' &&
                        $route.path != '/register' &&
                        $route.path != '/resetPassword' &&
                        $route.path != '/forgetPassword'
                "
                :class="[
                    sidebar ? '_left_sidebar _hide_sidebar' : '_left_sidebar',
                    lightSidebar ? '_light_sidebar' : '',
                    darkSidebar ? '_dark_sidebar' : '',
                    mobSidebar ? '_mobSidebarOpen' : ''
                ]"
            >
                <div class="_left_sidebar_main">
                    <!-- PROFILE PIC WITH NAME AND ROLE -->

                    <div class="_left_sidebar_menu _1scrollbar">
                        <Menu :theme="theme3" :active-name="activeRoute">
                            <MenuGroup title="Dashboard">
                                <p class="_group_name">
                                    <Icon type="ios-more" />
                                </p>
                                <MenuItem to="/staff" name="2">
                                    <Icon type="md-people" />
                                    <span class="submenu_text">Staff</span>
                                </MenuItem>
                                <MenuItem
                                    to="/reportingTime"
                                    name="reportingtime"
                                >
                                    <Icon type="ios-clock" />
                                    <span class="submenu_text"
                                        >Reporting Time</span
                                    >
                                </MenuItem>
                            </MenuGroup>
                        </Menu>
                    </div>

                    <div class="_left_sidebar_bottom _1border_color">
                        <Menu :theme="theme3" active-name="1">
                            <MenuItem name="sunny">
                                <Icon
                                    @click="lightSidebarClick"
                                    type="ios-sunny"
                                />
                                <span
                                    @click="lightSidebarClick"
                                    class="submenu_text"
                                    >Light</span
                                >
                            </MenuItem>
                            <MenuItem name="moon">
                                <Icon @click="darkModeClick" type="ios-moon" />
                                <span
                                    @click="darkModeClick"
                                    class="submenu_text"
                                    >Dark</span
                                >
                            </MenuItem>
                            <a
                                style="text-decoration:none;display:inline"
                                href="/logout"
                            >
                                <MenuItem name="logout">
                                    <Icon type="md-log-out" />
                                    <span class="submenu_text">Logout</span>
                                </MenuItem>
                            </a>
                        </Menu>
                        <!-- <p>Change theme</p>
                <RadioGroup v-model="theme3">
                    <Radio label="light"></Radio>
                    <Radio label="dark"></Radio>
            </RadioGroup>-->
                    </div>
                </div>
            </aside>
            <!-- Sidebar -->

            <div
                :class="[
                    sidebar ? '_main_layout _mini_main_layout' : '_main_layout',
                    $route.path != '/login' &&
                    $route.path != '/register' &&
                    $route.path != '/resetPassword' &&
                    $route.path != '/forgetPassword'
                        ? ''
                        : '_login_layout'
                ]"
            >
                <router-view></router-view>

                <Footer
                    v-if="
                        $route.path != '/login' &&
                            $route.path != '/register' &&
                            $route.path != '/resetPassword' &&
                            $route.path != '/forgetPassword' &&
                            $route.path != '/messenger'
                    "
                />
            </div>
        </div>
    </div>
</template>

<script>
import adminNotification from "../admin/components/adminNotification";
import Footer from "./footer.vue";
export default {
    components: {
        Footer,
        adminNotification
    },

    data() {
        return {
            activeRoute: "index",
            sidebar: false,
            isHovering: false,
            theme3: "light",
            lightSidebar: true,
            darkSidebar: false,
            darkMode: false,
            mobSearchOpen: false,
            mobSidebar: false
        };
    },

    methods: {
        async logout() {
            const logout = await this.callApi("get", "/logout");
        },
        lightSidebarClick() {
            this.lightSidebar = true;
            this.darkSidebar = false;
            this.darkMode = false;
        },

        darkModeClick() {
            this.darkSidebar = true;
            this.lightSidebar = false;
            this.darkMode = true;
        }
    },
    watch: {
        "$route.name": function(newVal, oldVal) {
            this.activeRoute = newVal;
        }
    },
    created() {
        this.activeRoute = this.$route.name;
    }
};
</script>

<style scoped>
.demo-spin-icon-load {
    animation: ani-demo-spin 1s linear infinite;
}
@keyframes ani-demo-spin {
    from {
        transform: rotate(0deg);
    }
    50% {
        transform: rotate(180deg);
    }
    to {
        transform: rotate(360deg);
    }
}
.demo-spin-col {
    height: 200px;
    position: relative;
    /* border: 1px solid #eee; */
}
</style>
