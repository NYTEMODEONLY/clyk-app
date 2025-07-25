'use client'

import { UAParser } from 'ua-parser-js'
import { getLinkByShortCode, addClickToLink } from './local-storage'

export async function handleRedirect(shortCode: string): Promise<string | null> {
  const link = getLinkByShortCode(shortCode)
  
  if (!link) {
    return null
  }
  
  // Track the click
  const userAgent = navigator.userAgent
  const referer = document.referrer || ''
  
  const parser = new UAParser(userAgent)
  const result = parser.getResult()
  
  // Get approximate location (mock for demo)
  let geoData = { country: 'Unknown', city: 'Unknown' }
  try {
    // In a real app, you'd use a service like ipapi.co
    // For demo, we'll use mock data based on time zone
    const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone
    if (timeZone.includes('America')) {
      geoData = { country: 'United States', city: 'New York' }
    } else if (timeZone.includes('Europe')) {
      geoData = { country: 'United Kingdom', city: 'London' }
    } else if (timeZone.includes('Asia')) {
      geoData = { country: 'Japan', city: 'Tokyo' }
    }
  } catch {
    // Fallback to unknown
  }
  
  addClickToLink(shortCode, {
    referer,
    userAgent,
    country: geoData.country,
    city: geoData.city,
    device: result.device.type || 'desktop',
    browser: result.browser.name || 'Unknown',
    os: result.os.name || 'Unknown',
  })
  
  return link.originalUrl
}