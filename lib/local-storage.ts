export interface Link {
  id: string
  originalUrl: string
  shortCode: string
  shortUrl: string
  title: string
  customAlias?: string
  createdAt: string
  clicks: Click[]
}

export interface Click {
  id: string
  timestamp: string
  referer?: string
  userAgent?: string
  country?: string
  city?: string
  device?: string
  browser?: string
  os?: string
}

export interface User {
  id: string
  name: string
  email: string
  avatar?: string
}

// Local Storage Keys
const LINKS_KEY = 'clyk_links'
const USER_KEY = 'clyk_user'

// Helper function to get base URL
export function getBaseUrl(): string {
  if (typeof window !== 'undefined') {
    return window.location.origin
  }
  return 'http://localhost:3000'
}

// Link Operations
export function getLinks(): Link[] {
  if (typeof window === 'undefined') return []
  
  try {
    const stored = localStorage.getItem(LINKS_KEY)
    return stored ? JSON.parse(stored) : []
  } catch {
    return []
  }
}

export function saveLink(link: Link): void {
  if (typeof window === 'undefined') return
  
  const links = getLinks()
  const existingIndex = links.findIndex(l => l.id === link.id)
  
  if (existingIndex >= 0) {
    links[existingIndex] = link
  } else {
    links.unshift(link)
  }
  
  localStorage.setItem(LINKS_KEY, JSON.stringify(links))
}

export function getLinkByShortCode(shortCode: string): Link | null {
  const links = getLinks()
  return links.find(link => link.shortCode === shortCode) || null
}

export function isShortCodeTaken(shortCode: string): boolean {
  return getLinkByShortCode(shortCode) !== null
}

export function addClickToLink(shortCode: string, clickData: Omit<Click, 'id' | 'timestamp'>): void {
  const links = getLinks()
  const linkIndex = links.findIndex(link => link.shortCode === shortCode)
  
  if (linkIndex >= 0) {
    const click: Click = {
      id: `click_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`,
      timestamp: new Date().toISOString(),
      ...clickData
    }
    
    links[linkIndex].clicks.push(click)
    localStorage.setItem(LINKS_KEY, JSON.stringify(links))
  }
}

// Analytics
export function getLinkAnalytics(linkId: string) {
  const links = getLinks()
  const link = links.find(l => l.id === linkId)
  
  if (!link) return null
  
  const clicks = link.clicks
  const totalClicks = clicks.length
  
  // Referrer analysis
  const refererCounts = clicks.reduce((acc, click) => {
    const referer = click.referer || 'Direct'
    acc[referer] = (acc[referer] || 0) + 1
    return acc
  }, {} as Record<string, number>)
  
  // Country analysis
  const countryCounts = clicks.reduce((acc, click) => {
    const country = click.country || 'Unknown'
    acc[country] = (acc[country] || 0) + 1
    return acc
  }, {} as Record<string, number>)
  
  // Device analysis
  const deviceCounts = clicks.reduce((acc, click) => {
    const device = click.device || 'Unknown'
    acc[device] = (acc[device] || 0) + 1
    return acc
  }, {} as Record<string, number>)
  
  // Browser analysis
  const browserCounts = clicks.reduce((acc, click) => {
    const browser = click.browser || 'Unknown'
    acc[browser] = (acc[browser] || 0) + 1
    return acc
  }, {} as Record<string, number>)
  
  return {
    link: {
      id: link.id,
      originalUrl: link.originalUrl,
      shortCode: link.shortCode,
      title: link.title,
      createdAt: link.createdAt,
    },
    analytics: {
      totalClicks,
      referers: Object.entries(refererCounts)
        .map(([name, count]) => ({ name, count }))
        .sort((a, b) => b.count - a.count),
      countries: Object.entries(countryCounts)
        .map(([name, count]) => ({ name, count }))
        .sort((a, b) => b.count - a.count),
      devices: Object.entries(deviceCounts)
        .map(([name, count]) => ({ name, count }))
        .sort((a, b) => b.count - a.count),
      browsers: Object.entries(browserCounts)
        .map(([name, count]) => ({ name, count }))
        .sort((a, b) => b.count - a.count),
    },
    recentClicks: clicks
      .sort((a, b) => new Date(b.timestamp).getTime() - new Date(a.timestamp).getTime())
      .slice(0, 20)
  }
}

// User Operations (Simple mock auth)
export function getCurrentUser(): User | null {
  if (typeof window === 'undefined') return null
  
  try {
    const stored = localStorage.getItem(USER_KEY)
    return stored ? JSON.parse(stored) : null
  } catch {
    return null
  }
}

export function saveUser(user: User): void {
  if (typeof window === 'undefined') return
  localStorage.setItem(USER_KEY, JSON.stringify(user))
}

export function signOut(): void {
  if (typeof window === 'undefined') return
  localStorage.removeItem(USER_KEY)
}

// Mock sign in (for demo purposes)
export function mockSignIn(name: string, email: string): User {
  const user: User = {
    id: `user_${Date.now()}`,
    name,
    email,
    avatar: `https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(name)}`
  }
  
  saveUser(user)
  return user
}