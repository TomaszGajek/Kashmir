<template>
    <div>
        {{this.item.title.rendered}}
    </div>
</template>

<script>
export default {
    props:{
        item:{
            type:Object
        }
    }
}
</script>
