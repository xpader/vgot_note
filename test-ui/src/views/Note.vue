<template>
	<v-app class="overflow-hidden fill-height" dark>
		<v-navigation-drawer app clipped width="220" class="fill-height" :value="showMenu">
			<v-list class="fill-height scroll-y">
				<v-list-tile @click="">
					<v-list-tile-action>
						<v-icon>home</v-icon>
					</v-list-tile-action>
					<v-list-tile-title>Home</v-list-tile-title>
				</v-list-tile>

				<v-list-group prepend-icon="account_circle" value="true">
					<v-list-tile slot="activator">
						<v-list-tile-title>笔记目录</v-list-tile-title>
					</v-list-tile>

					<v-list-group no-action sub-group value="true">
						<v-list-tile slot="activator">
							<v-list-tile-title>Admin</v-list-tile-title>
						</v-list-tile>

						<v-list-tile v-for="(admin, i) in admins" :key="i" @click="">
							<v-list-tile-title v-text="admin[0]"></v-list-tile-title>
						</v-list-tile>
					</v-list-group>

					<v-list-group sub-group no-action value="true">
						<v-list-tile slot="activator">
							<v-list-tile-title>Actions</v-list-tile-title>
						</v-list-tile>

						<v-list-tile v-for="(crud, i) in cruds" :key="i" @click="">
							<v-list-tile-title v-text="crud[0]"></v-list-tile-title>
						</v-list-tile>
					</v-list-group>
				</v-list-group>
			</v-list>
		</v-navigation-drawer>

		<v-toolbar app clipped-left>
			<v-toolbar-side-icon @click="showMenu=!showMenu"></v-toolbar-side-icon>

			<v-toolbar-title class="headline text-uppercase">
				<span>VT</span>
				<span class="font-weight-light">NOTE</span>
			</v-toolbar-title>

			<v-spacer></v-spacer>

			<v-btn flat href="https://github.com/vuetifyjs/vuetify/releases/latest" target="_blank">
				<span class="mr-2">Latest Release</span>
			</v-btn>

			<v-btn icon>
				<v-icon>search</v-icon>
			</v-btn>

			<v-btn icon>
				<v-icon>apps</v-icon>
			</v-btn>

			<v-btn icon>
				<v-icon>refresh</v-icon>
			</v-btn>

			<v-menu bottom left>
				<v-btn slot="activator" icon>
					<v-icon>more_vert</v-icon>
				</v-btn>

				<v-list>
					<v-list-tile v-for="(item, i) in items" :key="i" @click="">
						<v-list-tile-title>{{ item.title }}</v-list-tile-title>
					</v-list-tile>
				</v-list>
			</v-menu>

		</v-toolbar>

		<v-content app class="overflow-hidden fill-height">
			<v-container fluid fill-height class="pa-0">
				<v-layout row class="overflow-hidden">
					<v-flex xs3 class="scroll-y">
						<v-list two-line>
							<v-subheader>列表标题</v-subheader>
							<template v-for="(item, index) in list">
								<v-divider v-if="index>0" inset></v-divider>
								<v-list-tile
									:key="index"
									avatar
									@click=""
								>
									<v-list-tile-avatar>
										<img :src="item.avatar">
									</v-list-tile-avatar>

									<v-list-tile-content>
										<v-list-tile-title v-html="item.title"></v-list-tile-title>
										<v-list-tile-sub-title v-html="item.subtitle"></v-list-tile-sub-title>
									</v-list-tile-content>
								</v-list-tile>
							</template>
						</v-list>
					</v-flex>
					<v-flex xs9 class="scroll-y">
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
						<p>Hello World</p>
					</v-flex>
				</v-layout>
			</v-container>
		</v-content>

	</v-app>
</template>

<script>
export default {
	name: 'note-layout',
	data() {
		return {
			showMenu: true,
			admins: [
				['Management', 'people_outline'],
				['Settings', 'settings']
			],
			cruds: [
				['Create', 'add'],
				['Read', 'insert_drive_file'],
				['Update', 'update'],
				['Delete', 'delete']
			],
			items2: [
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
					title: 'Brunch this weekend?',
					subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
				},
				{divider: true, inset: true},
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
					title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
					subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
				},
				{divider: true, inset: true},
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
					title: 'Oui oui',
					subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
				}
			],
			items: [
				{title: '账号详情'},
				{title: '个人设置'},
				{title: '退出登录'}
			],
			list: [
				{
					avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
					title: 'Brunch this weekend?',
					subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
				}, {
					avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
					title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
					subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
				}, {
					avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
					title: 'Oui oui',
					subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
				}, {
					avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
					title: 'Oui oui',
					subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
				}, {
					avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
					title: 'Oui oui',
					subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
				}, {
					avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
					title: 'Oui oui',
					subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
				}, {
					avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
					title: 'Oui oui',
					subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
				}
			]
		};
	},
	mounted() {
	},
	components: {}
}
</script>
