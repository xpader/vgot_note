<style scoped>
</style>
<template>
	<div>
		<mu-appbar style="width: 100%;" color="primary">
			<mu-button icon slot="left">
				<mu-icon value="menu"></mu-icon>
			</mu-button>
			Title

			<mu-button flat slot="right">LOGIN</mu-button>
		</mu-appbar>
	</div>
</template>
<script>
import {AppBar, Button, Icon} from 'muse-ui';

export default {
	components: {MuAppbar:AppBar, MuButton:Button, MuIcon:Icon}
}
</script>