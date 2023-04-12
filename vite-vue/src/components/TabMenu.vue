<template>
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
                <a class="nav-link" :class="{ active: activeTab === index }" @click="activeTab = index">{{ tab }}</a>
            </li>
        </ul>
        <div class="tab-content mt-3">
            <div class="tab-pane" v-for="(content, index) in contents" :key="index"
                :class="{ active: activeTab === index }">
                {{ content }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        

        return {
            tabs: tabs,
            contents: contents,
            activeTab: 0,
        };
    },
};

</script>