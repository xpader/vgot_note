<template>
	<v-app>
		<v-navigation-drawer class="blue lighten-3" dark permanent app clipped>
			<v-list>
				<v-list-tile>
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
							<v-list-tile-action>
								<v-icon v-text="admin[1]"></v-icon>
							</v-list-tile-action>
						</v-list-tile>
					</v-list-group>

					<v-list-group sub-group no-action>
						<v-list-tile slot="activator">
							<v-list-tile-title>Actions</v-list-tile-title>
						</v-list-tile>

						<v-list-tile v-for="(crud, i) in cruds" :key="i" @click="">
							<v-list-tile-title v-text="crud[0]"></v-list-tile-title>
							<v-list-tile-action>
								<v-icon v-text="crud[1]"></v-icon>
							</v-list-tile-action>
						</v-list-tile>
					</v-list-group>
				</v-list-group>
			</v-list>
		</v-navigation-drawer>

		<v-toolbar app clipped-left flat>
			<v-toolbar-side-icon></v-toolbar-side-icon>

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

		<v-content>
			<v-container fluid>
				Hello World
			</v-container>
		</v-content>

		<v-footer app inset></v-footer>

		<!--<v-parallax :height="1500" src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-parallax>-->

		<!--
		<v-layout row>
			<v-flex xs12 sm6 offset-sm3>
				<v-card>
					<v-toolbar color="cyan" dark>
						<v-toolbar-side-icon></v-toolbar-side-icon>

						<v-toolbar-title>Inbox</v-toolbar-title>

						<v-spacer></v-spacer>

						<v-btn icon>
							<v-icon>search</v-icon>
						</v-btn>
					</v-toolbar>

					<v-list two-line>
						<template v-for="(item, index) in items2">
							<v-subheader v-if="item.header" :key="item.header">
								{{ item.header }}
							</v-subheader>

							<v-divider v-else-if="item.divider" :inset="item.inset" :key="index"></v-divider>

							<v-list-tile v-else :key="item.title" avatar @click="">
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
				</v-card>
			</v-flex>
		</v-layout>
		-->

	</v-app>
</template>

<script>
export default {
	name: 'note-layout',
	data() {
		return {
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
				{header: 'Today'},
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
			showMenu: false
		};
	},
	mounted() {
	},
	components: {}
}
</script>