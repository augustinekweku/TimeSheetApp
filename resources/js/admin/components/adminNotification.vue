<template>
    <li class="_1noti d-none">
        <Dropdown trigger="click" placement="bottom-end">
            <a href="javascript:void(0)">
                <Icon type="ios-mail-outline" />
                <p class="_noti_num">5</p>
            </a>
            <DropdownMenu slot="list">
                <p class="_1noti_title">Messages</p>

                <template v-if="!spinLoading">
                    <div class="_1noti_list _1scrollbar">
                        <!-- Items -->
                        <div
                            v-for="(item, index) in 2"
                            :key="index"
                            class="_1noti_list_items"
                        >
                            <div class="_1noti_list_pic">
                                <img
                                    class="_1noti_list_img"
                                    src="/static/img/photo.jpg"
                                    alt=""
                                    title=""
                                />
                            </div>

                            <div class="_1noti_list_details">
                                <p class="_1noti_list_name _1text_overflow">
                                    Arnold Schwarzenegger
                                </p>
                                <p class="_1noti_list_title _1text_overflow">
                                    has comment on your board
                                </p>

                                <p class="_1noti_list_time">10:12:2020</p>
                            </div>
                        </div>
                        <!-- Items -->
                    </div>

                    <div class="_1noti_see">
                        <a class="_1noti_see_text _2link" href=""
                            >See all notifications</a
                        >
                    </div>
                </template>

                <template v-else>
                    <div class="_noti_load demo-spin-col">
                        <Spin fix>
                            <Icon
                                type="ios-loading"
                                size="18"
                                class="demo-spin-icon-load"
                            ></Icon>
                            <div>Loading</div>
                        </Spin>
                    </div>
                </template>
            </DropdownMenu>
        </Dropdown>
    </li>
</template>

<script>
export default {
    data() {
        return {
            spinLoading: false,
            NotificationsCount: 0,
            Notifications: []
        };
    },
    methods: {
        async getNotifications() {
            //const getNotifications = await this.callApi('get', 'app/get_notifications');
            const Notifications = await this.callApi(
                "get",
                "app/get_last_notification"
            );

            //console.log(Notifications.data.notifications_count);
            if (
                Notifications.status === 200 &&
                Notifications.data.notifications_count > 0
            ) {
                //notify the admin if the latest reported time is late
                //console.log(Notifications);
                if (
                    Notifications.data.notifications[0].status === 0 &&
                    Notifications.data.notifications_count >
                        this.NotificationsCount
                ) {
                    this.NotificationsCount =
                        Notifications.data.notifications_count;
                    this.Notifications = Notifications.data.notifications;
                    return this.showNotification(
                        Notifications.data.notifications[0].name,
                        humanizeDuration(
                            Notifications.data.notifications[0].timediff
                        )
                    );
                }
            }
        },
        showNotification(name, timediff) {
            Push.create("Timesheet App", {
                body: `${name} was late for ${timediff}`,
                timeout: 5000
            });
        }
    },
    created() {
        setInterval(this.getNotifications, 2000);
    }
};
</script>
