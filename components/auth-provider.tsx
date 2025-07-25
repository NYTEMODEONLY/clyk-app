'use client'

import { createContext, useContext, useEffect, useState, ReactNode } from 'react'
import { getCurrentUser, saveUser, signOut, mockSignIn, User } from '@/lib/local-storage'

interface AuthContextType {
  user: User | null
  signIn: (name: string, email: string) => void
  signOut: () => void
  isLoading: boolean
}

const AuthContext = createContext<AuthContextType | undefined>(undefined)

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(null)
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    // Load user from localStorage on mount
    const currentUser = getCurrentUser()
    setUser(currentUser)
    setIsLoading(false)
  }, [])

  const handleSignIn = (name: string, email: string) => {
    const newUser = mockSignIn(name, email)
    setUser(newUser)
  }

  const handleSignOut = () => {
    signOut()
    setUser(null)
  }

  return (
    <AuthContext.Provider value={{
      user,
      signIn: handleSignIn,
      signOut: handleSignOut,
      isLoading
    }}>
      {children}
    </AuthContext.Provider>
  )
}

export function useAuth() {
  const context = useContext(AuthContext)
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider')
  }
  return context
}