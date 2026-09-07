
export interface registerUser {
  name: string,
  email: string,
  password: string,
  confirmPassword: string,
}

export interface loginUser {
  email: string,
  password: string
}

export interface User {
  name: string,
  email: string,
  created_at: string,
}

export interface StatisticUser {
  projects: { 
    total: number;
    active: number;
    archived: number;
  };
  tasks: { 
    total: number;
    todo: number;
    in_progress: number;
    done: number;
  };
}