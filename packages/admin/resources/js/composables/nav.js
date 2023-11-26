import { HomeIcon, InboxIcon, UserIcon, PlayIcon, DocumentReportIcon } from '@heroicons/vue/outline'

export const Nav = [
  {'label': 'Главная', 'uri': '/', 'icon': HomeIcon},
  {'label': 'Мои задачи', 'uri': '/tasks', 'icon': InboxIcon},
  {'label': 'В работе', 'uri': '/works', 'icon': PlayIcon},
  {'label': 'Отчеты', 'uri': '/reports', 'icon': DocumentReportIcon},
  {'label': 'Пользователи', 'uri': '/users', 'icon': UserIcon, 'permission': 'user:view'},
]
