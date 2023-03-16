<template>
    <div>
        <h1>Dashboard Moderation</h1>
        <table class="tab">
            <thead>
                <tr class="tab">
                    <th class="dashboard-admin">User</th>
                    <th class="dashboard-admin">Comment</th>
                    <th class="dashboard-admin">Actions</th>
                </tr>
                <tr>
                    <td class="dashboard-admin">User 1</td>
                    <td class="dashboard-admin">blablabla</td>
                    <td class="dashboard-admin action">
                        <p class="keep">Good</p>
                        <p class="bin">Delete</p>
                    </td>
                </tr>
                <tr>
                    <td class="dashboard-admin">User 2</td>
                    <td class="dashboard-admin">blablabla</td>
                    <td class="dashboard-admin action">
                        <p class="keep">Good</p>
                        <p class="bin">Delete</p>
                    </td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</template>
<style>

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
}

.bin {
    background-color: red;
    color: white;
    padding: 5px;
    border-radius: 5px;
}

</style>

<script lang="ts">
import { ref, reactive, onBeforeMount } from 'vue';
import { useRoute } from 'vue-router';

    const API_URL = 'https://localhost';

    export default {
        
        setup () {
            const seances = reactive([]);
            const showModals = reactive(Array(seances.length).fill(false))
            onBeforeMount(async () => {
                try {
                    const moderation_alls = await fetch(`${API_URL}/moderations`);
                    const data_moderation = await moderation_alls.json();
                    console.log(data_moderation);
                } catch (error) {
                    console.log(error);
                }
            
            });
            
            return {
                
            }
        }                
        
        
    
    };
</script>
