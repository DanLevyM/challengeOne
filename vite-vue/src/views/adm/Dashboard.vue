<template>
    <div>
        <h1>Dashboard Moderation</h1>
        <table class="tab">
            <thead>
                <tr class="tab">
                    <th class="dashboard-admin">User</th>
                    <th class="dashboard-admin">Title</th>
                    <th class="dashboard-admin">Comment</th>
                    <th class="dashboard-admin">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(dashboardItem, index) in dashboardList"
                    :key="index"
                >
                    <td class="dashboard-admin">{{ dashboardItem.user }}</td>
                    <td class="dashboard-admin">{{ dashboardItem.title }}</td>
                    <td class="dashboard-admin">
                        {{ dashboardItem.description }}
                    </td>
                    <td class="dashboard-admin action">
                        <p
                            class="keep"
                            @click="ignoreReporting(dashboardItem.modId)"
                        >
                            Ignore
                        </p>
                        <p
                            class="ban"
                            @click="banReporting(dashboardItem.modId)"
                        >
                            Ban
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-if="showMessage" class="message">{{ message }}</div>
</template>

<script lang="ts">
import { ref, reactive, onBeforeMount } from "vue";

const API_URL = import.meta.env.VITE_API_URL;

export default {
    setup() {
        const moderations: Array<any> = reactive([]);
        let dashboardList: Array<any> = reactive([]);
        const showMessage = ref(false);
        const message = ref("");

        const seances = reactive([]);
        const showModals = reactive(Array(seances.length).fill(false));
        const jwtToken = localStorage.getItem("access_token");

        onBeforeMount(async () => {
            try {
                // Retrieve moderations
                const moderation_alls = await fetch(`${API_URL}/moderations`, {
                    headers: {
                        'Authorization': "Bearer " + jwtToken
                    }
                });
                const data_moderation = await moderation_alls.json();
                moderations.push(...data_moderation["hydra:member"]);
                const LIMIT_SIGNALS_AUTHORIZED = 3;

                // Retrieve comments and authors
                for (let moderation of moderations) {
                    if (moderation.counterUserBan >= LIMIT_SIGNALS_AUTHORIZED) {
                        const user = await fetch(
                            `${API_URL}${moderation.userId}`
                        );
                        const data_user = await user.json();

                        const comment = await fetch(
                            `${API_URL}${moderation.commentaireId}`, 
                            {
                                headers: {
                                    'Authorization': 'Bearer ' + jwtToken
                                }
                            }
                        );
                        const data_comment = await comment.json();

                        dashboardList.push({
                            user: data_user.email,
                            title: data_comment.title,
                            description: data_comment.description,
                            modId: moderation["@id"],
                        });
                        // console.log(dashboardList);
                    }
                }
            } catch (error) {
                console.log(error);
            }
        });

        async function ignoreReporting(moderationId: string) {
            console.log("ignoreReporting", moderationId);
            try {
                await fetch(`${API_URL}${moderationId}`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/merge-patch+json",
                        'Authorization': 'Bearer ' + jwtToken
                    },
                    body: JSON.stringify({
                        counterUserBan: 0,
                    }),
                });

                showMessage.value = true;
                message.value = "Signalement ignoré !";
                setTimeout(() => {
                    showMessage.value = false;
                }, 3000);
            } catch (error) {
                console.log(error);
            }
        }

        async function banReporting(moderationId: string) {
            console.log("banReporting", moderationId);
            try {
                await fetch(`${API_URL}${moderationId}`, {
                    method: "DELETE",
                    headers: {
                        'Authorization': 'Bearer ' + jwtToken
                    }
                });

                showMessage.value = true;
                message.value = "Commentaire supprimé !";
                setTimeout(() => {
                    showMessage.value = false;
                }, 3000);
            } catch (error) {
                console.log(error);
            }
        }

        return {
            dashboardList,
            ignoreReporting,
            banReporting,
            showMessage,
            message,
        };
    },
};
</script>

<style>
th,
td {
    color: black;
}

.dashboard-admin {
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.tab {
    width: 100%;
}

.action {
    display: flex;
    justify-content: space-around;
}

.keep {
    background-color: green;
    color: white;
    padding: 5px;
    border-radius: 5px;
    cursor: pointer;
}

.ban {
    background-color: red;
    color: white;
    padding: 5px;
    border-radius: 5px;
    cursor: pointer;
}

.message {
    position: absolute;
    right: 20px;
    bottom: 20px;
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
}
</style>
